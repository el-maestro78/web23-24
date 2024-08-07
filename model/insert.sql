INSERT INTO base (lat, long) VALUES
(38.246444, 21.734203),
(38.258236, 21.743137),
(38.244872, 21.731950);

INSERT INTO vehicles (username, lat, long) VALUES
('bear', 38.246444, 21.734203),
('lion', 38.258236, 21.743137),
('giraffe', 38.244872, 21.731950);

INSERT INTO dbUser(user_id, first_name,surname,username,pass,is_resc,is_admin,email,phone,long,lat) VALUES 
(78, 'Admin', 'Adminopoulos', 'tester', 'pass', FALSE, TRUE, 'admin@admin.org', 6987654321, 38.246444, 21.734203);

INSERT INTO item_category(category_id, category_name, details) VALUES
(0, 'spam', 'Another Viking victory');

INSERT INTO  items(item_id, iname, quantity, category, details) VALUES
(0,'spam', 1, 0, 'Just spam'),
(1,'spam, eggs & spam', 10, 0,'Less spam in it'),
(2,'spam, eggs, spam, spam & spam', 100, 0, 'Better than spam eggs spam');

INSERT INTO requests(pending, quantity, reg_date, assign_date, user_id, item_id, long, lat) VALUES 
(FALSE, 1, current_date, current_date, 78, 1, 21.731021839078, 38.244808224971),
(FALSE, 1, current_date, current_date, 78, 2, 21.734499691362, 38.246439932828),
(TRUE, 1, current_date, NULL, 78, 0, 21.734503111278, 38.245888739736),
(TRUE, 1, current_date, NULL, 78, 1, 21.732724118553, 38.244914513495);

INSERT INTO offers(pending, quantity, reg_date, assign_date, user_id, item_id, long, lat) VALUES 
(FALSE, 1, current_date, current_date, 78, 1, 21.738, 38.268809889),
(FALSE, 1, current_date, current_date, 78, 2, 21.745, 38.24909828),
(TRUE, 1, current_date, NULL, 78, 0, 21.800, 38.2356855),
(TRUE, 1, current_date, NULL, 78, 1, 21.850, 38.230);
