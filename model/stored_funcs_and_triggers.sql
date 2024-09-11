CREATE OR REPLACE FUNCTION complete_offer()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE offers
    SET completed = TRUE, completed_date = CURRENT_DATE
    WHERE off_id = NEW.off_id;

    INSERT INTO vehicle_load (veh_id, item_id, load)
    VALUES (
        (SELECT veh_id FROM tasks WHERE off_id = NEW.off_id),
        NEW.item_id,
    NEW.quantity
    )
    ON CONFLICT (veh_id, item_id) DO UPDATE
    SET load = vehicle_load.load + EXCLUDED.quantity;

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
BEGIN
    UPDATE requests
    SET completed = TRUE, completed_date = CURRENT_DATE
    WHERE req_id = NEW.req_id;

    UPDATE vehicle_load
    SET load = load - NEW.quantity
    WHERE veh_id = (SELECT veh_id FROM tasks WHERE req_id = NEW.req_id)
    AND item_id = NEW.item_id;

    DELETE FROM vehicle_load
    WHERE veh_id = (SELECT veh_id FROM tasks WHERE req_id = NEW.req_id)
    AND item_id = NEW.item_id
    AND load <= 0;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER request_completion_trigger
AFTER UPDATE OF completed
ON tasks
FOR EACH ROW
WHEN (NEW.completed = TRUE)
EXECUTE FUNCTION complete_request();
