INSERT INTO base (lat, long) VALUES
(38.246444, 21.734203),
(38.258236, 21.743137),
(38.244872, 21.731950);

INSERT INTO vehicles (username, lat, long) VALUES
('bear', 38.246444, 21.734203),
('lion', 38.258236, 21.743137),
('RAT', 38.244872, 21.731950),
('giraffe', 38.244872, 21.731950);

INSERT INTO dbUser(first_name,surname,username,pass,is_resc,is_admin,email,phone,long,lat) VALUES
( 'Admin', 'Adminopoulos', 'tester', crypt('pass', gen_salt('bf')), FALSE, TRUE, 'admin@admin.org', 6987654321, 38.246444, 21.734203),
('Dr','Gumpy','tester2',crypt('pass', gen_salt('bf')),TRUE,FALSE,'a@a',6987654321, 21.734203, 38.246444),
('Michael','Palin','tester3', crypt('s', gen_salt('bf')),FALSE,FALSE,'s@s',6987654321, 39.8, 22.5),
('Eric','Idle','tester4',crypt('a', gen_salt('bf')),FALSE,TRUE,'tete@te.te',6987654321, 39.8, 22.5),
('TestUser1fn', 'TestUser1ln', 'testuser1', crypt('pass1', gen_salt('bf')), FALSE, FALSE, 'testuser1@gmail.com', 6901111111, 41.8, 21.5),
('TestUser2fn', 'TestUser2ln', 'testuser2', crypt('pass2', gen_salt('bf')), FALSE, FALSE, 'testuser2@gmail.com', 6902222222, 42.8, 22.5),
('TestUser3fn', 'TestUser3ln', 'testuser3', crypt('pass3', gen_salt('bf')), FALSE, FALSE, 'testuser3@gmail.com', 6903333333, 43.8, 23.5),
( 'Rescuer1fn', 'Rescuer1ln', 'rescuer1', crypt('pass11', gen_salt('bf')), TRUE, FALSE, 'rescuer1@gmail.com', 6911111111, 44.8, 24.5),
('Rescuer2fn', 'Rescuer2ln', 'rescuer2', crypt('pass12', gen_salt('bf')), TRUE, FALSE, 'rescuer2@gmail.com', 6912121212, 45.8, 25.5),
('Rescuer3fn', 'Rescuer3ln', 'rescuer3', crypt('pass13', gen_salt('bf')), TRUE, FALSE, 'rescuer3@gmail.com', 6913131313, 44.8, 24.5);



INSERT INTO item_category(category_name, details) VALUES
('spam', 'Another Viking victory'),
('athletic', 'Good old exercise');

INSERT INTO  items(iname, quantity, category, details) VALUES
('spam', 1, 1, 'Just spam'),
('spam, eggs & spam', 10, 1,'Less spam in it'),
('spam, eggs, spam, spam & spam', 100, 1, 'Better than spam eggs spam'),
('Basketball Ball', 50, 2, 'Just a basketball ball');

INSERT INTO requests(pending, completed, quantity, reg_date, assign_date, user_id, item_id, long, lat) VALUES
(FALSE, FALSE, 5, current_date, current_date, 1, 1, 21.731021839078, 38.244808224971),
(FALSE, FALSE, 10, current_date, current_date, 1, 2, 21.734499691362, 38.246439932828),
(TRUE, FALSE, 5, current_date, NULL, 1, 3, 21.734503111278, 38.245888739736),
(TRUE, FALSE, 10, current_date, NULL, 1, 1, 21.732724118553, 38.244914513495),
(FALSE, TRUE, 25, current_date, current_date, 1, 3, 21.78, 38.45);

INSERT INTO offers(pending, completed, quantity, reg_date, assign_date, completed_date, user_id, item_id, long, lat) VALUES
(FALSE, FALSE, 5, current_date,  current_date,NULL, 3, 1, 21.738, 38.268809889),
(FALSE, FALSE, 10, current_date, current_date, NULL, 3, 2, 23.745, 38.0),
(TRUE, FALSE, 5, current_date, current_date,NULL, 3, 1, 21.800, 38.2356855),
(TRUE, FALSE, 10, current_date, current_date,NULL, 3, 2, 21.850, 38.230),
(FALSE, TRUE, 1, current_date, current_date,current_date, 3, 1, 21.100, 38.230),
(FALSE, TRUE, 1, current_date, current_date,current_date, 3, 1, 21.100, 38.230);

INSERT INTO tasks(user_id, veh_id, off_id, req_id, completed) VALUES
(1, 1, 2, NULL, FALSE),
(1, 1, NULL, 1, FALSE),
(1, 2, 1, NULL, FALSE),
(1, 2, NULL, 1, FALSE),
(1, 3, NULL, 2, FALSE),
(1, 3, NULL, 1, TRUE);

INSERT INTO vehicle_load(veh_id, item_id, load) VALUES
(1, 1, 5),
(1, 2, 10),
(2, 2, 10);

INSERT INTO news(title, descr, date, base_id, item_id) VALUES
('Test', 'Bored already?', current_date, 1, 1),
('Test2', 'Yes?', current_date, 1, 1),
('Test3', 'Tired too?', current_date, 1, 1);
