INSERT INTO base (lat, long) VALUES
(38.246444, 21.734203),
(38.258236, 21.743137),
(38.244872, 21.731950);

INSERT INTO vehicles (lat, long) VALUES
(38.246444, 21.734203),
(38.258236, 21.743137),
(38.244872, 21.731950),
(38.245572, 21.732050),
(38.254872, 21.731570),
(38.244872, 21.74);

INSERT INTO dbUser(first_name, surname, username, pass, is_resc, is_admin, email, phone, long, lat) VALUES
( 'Admin', 'Adminopoulos', 'admin1', crypt('pass', gen_salt('bf')), FALSE, TRUE, 'admin@admin.org', 6987654321, 38.246444, 21.734203),
('Tete','Tete','admin2',crypt('a', gen_salt('bf')),FALSE,TRUE,'tete@te.te',6987654321, 39.8, 22.5),
('Mike','Choko','admin3',crypt('pass', gen_salt('bf')),FALSE,TRUE,'mike@hotmail.com',6987654321, 39.8, 22.5),
('Teo','Giannak','admin4',crypt('pass', gen_salt('bf')),FALSE,TRUE,'teo@att.com',6987654321, 39.8, 22.5),

('Dr','Gumpy','rescuer1',crypt('pass', gen_salt('bf')),TRUE,FALSE,'a@a',6987654321, 21.734203, 38.246444),
('Rescuer1fn', 'Rescuer1ln', 'rescuer2', crypt('pass11', gen_salt('bf')), TRUE, FALSE, 'rescuer1@gmail.com', 6911111111, 44.8, 24.5),
('Rescuer2fn', 'Rescuer2ln', 'rescuer3', crypt('pass12', gen_salt('bf')), TRUE, FALSE, 'rescuer2@gmail.com', 6912121212, 45.8, 25.5),
('Rescuer3fn', 'Rescuer3ln', 'rescuer4', crypt('pass13', gen_salt('bf')), TRUE, FALSE, 'rescuer3@gmail.com', 6913131313, 44.8, 24.5),
('Rescuer4fn', 'Rescuer4ln', 'rescuer5', crypt('pass14', gen_salt('bf')), TRUE, FALSE, 'rescuer4@gmail.com', 6913131313, 44.8, 24.5),

('Michael','Palin','tester1', crypt('s', gen_salt('bf')),FALSE,FALSE,'s@s',6987654321, 39.8, 22.5),
('Eric', 'Idle', 'tester2', crypt('pass1', gen_salt('bf')), FALSE, FALSE, 'testuser1@gmail.com', 6901111111, 41.8, 21.5),
('Graham', 'Chapman', 'tester3', crypt('pass2', gen_salt('bf')), FALSE, FALSE, 'testuser2@gmail.com', 6902222222, 42.8, 22.5),
('Terry', 'Jones', 'tester4', crypt('pass3', gen_salt('bf')), FALSE, FALSE, 'testuser3@gmail.com', 6902222222, 42.8, 22.5),
('John', 'Cleese', 'tester5', crypt('pass4', gen_salt('bf')), FALSE, FALSE, 'testuser4@gmail.com', 6903333333, 43.8, 23.5);

INSERT INTO item_category(category_name, details) VALUES
('spam', 'Another Viking victory'),
('athletic', 'Good old exercise');

INSERT INTO items(iname, quantity, category, details) VALUES
('spam', 1, 1, 'Just spam'),
('spam, eggs & spam', 10, 1,'Less spam in it'),
('spam, eggs, spam, spam & spam', 100, 1, 'Better than spam eggs spam'),
('spam, eggs, spam, spam, spam, spam, spam', 100, 1, 'The best'),
('Football Ball', 100, 2, 'Just a football ball'),
('Football shirt', 100, 2, 'Just a football shirt'),
('Basketball Ball', 50, 2, 'Just a basketball ball'),
('Basketball shirt', 100, 2, 'Just a basketball shirt');

INSERT INTO requests(pending, completed, quantity, reg_date, assign_date, completed_date, user_id, item_id, long, lat) VALUES
--(TRUE, FALSE, 5, current_date, NULL, NULL,12, 3, 21.734503111278, 38.246),
--(TRUE, FALSE, 5, current_date, NULL, NULL,13, 4, 21.753, 38.17),
(FALSE, FALSE, 5, current_date, NULL, NULL,10, 1, 21.744503111278, 38.255888739736),
(FALSE, FALSE, 5, current_date, NULL, NULL,10, 2, 21.732724118553, 38.244914513495),
(FALSE, FALSE, 25, current_date, current_date, NULL,10, 3, 21.78, 38.48),
(FALSE, TRUE, 30, current_date, current_date, current_date,10, 3, 21.75, 38.45),

(FALSE, FALSE,15, current_date, NULL, NULL,11, 1, 21.631021839078, 38.244808224971),
(FALSE, FALSE,20, current_date, current_date, NULL,11, 2, 21.734499691362, 38.246439932828),
(FALSE, FALSE,25, current_date, current_date, NULL,11, 3, 21.68, 38.55),
(FALSE, FALSE,30, current_date, current_date, NULL,11, 3, 21.58, 38.68),

(FALSE, FALSE,15, current_date, current_date, NULL,12, 1, 21.631021839078, 38.344808224971),
(FALSE, FALSE,20, current_date, current_date, NULL,12, 2, 21.734499691362, 38.447439932828),
(FALSE, TRUE,25, current_date, current_date, current_date,12, 1, 21.831021839078, 38.234808224971),
(FALSE, FALSE,30, current_date, current_date, NULL,12, 2, 21.7346, 38.248),

(TRUE, FALSE,100, current_date, NULL, NULL, 10, 3, 21.02486, 38.0564),
(TRUE, FALSE,100, current_date, NULL, NULL, 11, 4, 21.07346, 38.02438),
(TRUE, FALSE,100, current_date, NULL, NULL, 12, 5, 21.0464, 38.023238);



INSERT INTO offers(pending, completed, quantity, reg_date, assign_date, completed_date, user_id, item_id, long, lat) VALUES
(FALSE, FALSE, 5, current_date, current_date, NULL,10, 1, 21.7348, 38.249736),
(FALSE, FALSE, 5, current_date, current_date, NULL,10, 2, 21.732723, 38.24495),
(FALSE, FALSE, 25, current_date, current_date, NULL,10, 3, 21.768, 38.845),
(FALSE, TRUE, 30, current_date, current_date, current_date,10, 3, 21.078, 38.945),

(FALSE, FALSE,15, current_date, current_date, NULL,13, 1, 21.7078, 38.2971),
(FALSE, FALSE,20, current_date, current_date, NULL,13, 2, 21.7691362, 38.32828),
(FALSE, FALSE,25, current_date, current_date, NULL,13, 3, 21.998, 38.895),
(FALSE, FALSE,30, current_date, current_date, NULL,13, 3, 21.998, 38.998),

(FALSE, FALSE,15, current_date, current_date, NULL,14, 1, 21.08780, 38.201),
(FALSE, FALSE,20, current_date, current_date, NULL,14, 2, 21.09691362, 38.52028),
(FALSE, TRUE,25, current_date, current_date, current_date,14, 1, 21.8039078, 38.204971),
(FALSE, FALSE,30, current_date, current_date, NULL,14, 2, 21.4073, 38.5608),

(TRUE, FALSE,30, current_date, NULL, NULL,11, 3, 21.50646, 38.7024),
(TRUE, FALSE,30, current_date, NULL, NULL,13, 4, 21.24036, 38.203528),
(TRUE, FALSE,30, current_date, NULL, NULL,14, 5, 21.23405, 38.4064);



INSERT INTO vehicle_load(veh_id, item_id, load) VALUES
(1, 1, 5),
(1, 2, 10),
(2, 2, 10);

INSERT INTO  vehicle_rescuers(veh_id, user_id) VALUES
(1, 5),
(2, 6),
(3, 7),
(4, 8),
(5, 9);

INSERT INTO news(title, descr, date, base_id, item_id) VALUES
('I need Virgils shirt', 'I am just a fan, is that bad?', current_date, 1, 6),
('I need spam', 'Hungry for some good old spam', current_date, 2, 1),
('Fournie ur shirt man', 'U did the wrong choice though', current_date, 2, 8),
('Please more spam', 'I am addicted', current_date, 1, 3);

INSERT INTO tasks(user_id, veh_id, off_id, req_id, completed) VALUES
(5, 1, NULL, 1, FALSE),
(5, 1, NULL, 2, FALSE),
(5, 1, NULL, 3, FALSE),
(5, 1, NULL, 4, TRUE),
(6, 2, NULL, 5, FALSE),
(6, 2, NULL, 6, FALSE),
(8,4, NULL, 7, FALSE),
(8,4, NULL, 8, FALSE),
(7, 3, NULL, 9, FALSE),
(7, 3, NULL, 10, FALSE),
(9,5, NULL, 11, TRUE),
(9,5, NULL, 12, FALSE),
(5, 1, 1, NULL, FALSE),
(5, 1, 2, NULL, FALSE),
(5, 1, 3, NULL, FALSE),
(5, 1, 4, NULL, TRUE),
(8, 4, 5, NULL, FALSE),
(8, 4, 6, NULL, FALSE),
(6, 2, 7, NULL, FALSE),
(6, 2, 8, NULL, FALSE),
(9, 5, 9, NULL, FALSE),
(9, 5, 10, NULL, FALSE),
(7, 3, 11, NULL, TRUE),
(7, 3, 12, NULL, FALSE);
--(5, 1, 1, NULL, TRUE),
--(6, 2, 1, NULL, TRUE),
--(7, 3, 1, NULL, TRUE);
