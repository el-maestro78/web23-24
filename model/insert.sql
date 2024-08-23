INSERT INTO base (lat, long) VALUES
(38.246444, 21.734203),
(38.258236, 21.743137),
(38.244872, 21.731950);

INSERT INTO vehicles (veh_id, username, lat, long) VALUES
(0, 'bear', 38.246444, 21.734203),
(1, 'lion', 38.258236, 21.743137),
(2, 'RAT', 38.244872, 21.731950),
(3, 'giraffe', 38.244872, 21.731950);

INSERT INTO dbUser(first_name,surname,username,pass,is_resc,is_admin,email,phone,long,lat) VALUES
( 'Admin', 'Adminopoulos', 'tester', 'pass', FALSE, TRUE, 'admin@admin.org', 6987654321, 38.246444, 21.734203),
('Dr','Gumpy','tester2','pass',TRUE,FALSE,'a@a',6987654321, 21.734203, 38.246444),
('Michael','Palin','tester3','s',FALSE,FALSE,'s@s',6987654321, 39.8, 22.5),
('Eric','Idle','tester4','a',FALSE,TRUE,'tete@te.te',6987654321, 39.8, 22.5),
('TestUser1fn', 'TestUser1ln', 'testuser1', 'pass1', FALSE, FALSE, 'testuser1@gmail.com', 6901111111, 41.8, 21.5),
('TestUser2fn', 'TestUser2ln', 'testuser2', 'pass2', FALSE, FALSE, 'testuser2@gmail.com', 6902222222, 42.8, 22.5),
('TestUser3fn', 'TestUser3ln', 'testuser3', 'pass3', FALSE, FALSE, 'testuser3@gmail.com', 6903333333, 43.8, 23.5),
( 'Rescuer1fn', 'Rescuer1ln', 'rescuer1', 'pass11', TRUE, FALSE, 'rescuer1@gmail.com', 6911111111, 44.8, 24.5),
( 'Rescuer2fn', 'Rescuer2ln', 'rescuer2', 'pass12', TRUE, FALSE, 'rescuer2@gmail.com', 6912121212, 45.8, 25.5),
( 'Rescuer3fn', 'Rescuer3ln', 'rescuer3', 'pass13', TRUE, FALSE, 'rescuer3@gmail.com', 6913131313, 44.8, 24.5);

INSERT INTO item_category(category_id, category_name, details) VALUES
(0, 'spam', 'Another Viking victory'),
(1, 'athletic', 'Good old exercise');

INSERT INTO  items(item_id, iname, quantity, category, details) VALUES
(0,'spam', 1, 0, 'Just spam'),
(1,'spam, eggs & spam', 10, 0,'Less spam in it'),
(2,'spam, eggs, spam, spam & spam', 100, 0, 'Better than spam eggs spam'),
(3,'Basketball Ball', 50, 1, 'Just a basketball ball');

INSERT INTO requests(req_id, pending, completed, quantity, reg_date, assign_date, user_id, item_id, long, lat) VALUES 
(0, FALSE, FALSE, 5, current_date, current_date, 1, 1, 21.731021839078, 38.244808224971),
(1, FALSE, FALSE, 10, current_date, current_date, 1, 2, 21.734499691362, 38.246439932828),
(2, TRUE, FALSE, 5, current_date, NULL, 1, 0, 21.734503111278, 38.245888739736),
(3, TRUE, FALSE, 10, current_date, NULL, 1, 1, 21.732724118553, 38.244914513495),
(4, FALSE, TRUE, 25, current_date, current_date, 1, 3, 21.78, 38.45);

INSERT INTO offers(off_id, pending, completed, quantity, reg_date, assign_date, user_id, item_id, long, lat) VALUES 
(0, FALSE, FALSE, 5, current_date, current_date, 1, 1, 21.738, 38.268809889),
(1, FALSE, FALSE, 10, current_date, current_date, 1, 2, 23.745, 38.0),
(2, TRUE, FALSE, 5, current_date, NULL, 1, 0, 21.800, 38.2356855),
(3, TRUE, FALSE, 10, current_date, NULL, 1, 1, 21.850, 38.230),
(4, FALSE, TRUE, 1, current_date, NULL, 1, 1, 21.100, 38.230);

INSERT INTO tasks(tasks_id, user_id, veh_id, off_id, req_id, completed) VALUES 
(0, 1, 1, 0, NULL, FALSE),
(5, 1, 1, NULL, 0, FALSE),
(1, 1, 2, 1, NULL, FALSE),
(2, 1, 0, NULL, 0, FALSE),
(3, 1, 0, NULL, 1, FALSE),
(4, 1, 1, NULL, 0, TRUE);

INSERT INTO vehicle_load(veh_id, item_id, load) VALUES
(0, 1, 5),
(0, 2, 10),
(1, 2, 10);
