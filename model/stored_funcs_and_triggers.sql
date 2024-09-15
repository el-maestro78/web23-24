CREATE OR REPLACE FUNCTION complete_offer()
RETURNS TRIGGER AS $$
DECLARE
    quantity_value INT;
BEGIN
    SELECT quantity INTO quantity_value
    FROM offers
    WHERE off_id = NEW.off_id;

    UPDATE offers
    SET completed = TRUE, completed_date = CURRENT_DATE
    WHERE off_id = NEW.off_id;

    UPDATE vehicle_load
    SET load = load - quantity_value
    WHERE veh_id = (SELECT veh_id FROM tasks WHERE off_id = NEW.off_id)
    AND item_id = (SELECT  item_id FROM offers WHERE offers.off_id = NEW.off_id);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER offer_completion_trigger
AFTER UPDATE OF completed
ON tasks
FOR EACH ROW
WHEN (NEW.completed = TRUE)
EXECUTE FUNCTION complete_offer();

CREATE OR REPLACE FUNCTION complete_request()
RETURNS TRIGGER AS $$
    DECLARE
    quantity_value INT;
BEGIN
    SELECT quantity INTO quantity_value
    FROM requests
    WHERE req_id = NEW.req_id;

    UPDATE requests
    SET completed = TRUE, completed_date = CURRENT_DATE
    WHERE req_id = NEW.req_id;

    UPDATE vehicle_load
    SET load = load - quantity_value
    WHERE veh_id = (SELECT veh_id FROM tasks WHERE req_id = NEW.req_id)
    AND item_id = (SELECT  item_id  FROM requests WHERE requests.req_id = NEW.req_id);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER request_completion_trigger
AFTER UPDATE OF completed
ON tasks
FOR EACH ROW
WHEN (NEW.completed = TRUE)
EXECUTE FUNCTION complete_request();
