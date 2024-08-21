CREATE DATABASE webproject24;

\c webproject24;
--μου βγάζουν erron:webproject24=#
/*ERROR:  syntax error at or near "NOT"
LINE 2:     long DOUBLE PRECISION NOT NULL,*/

CREATE TABLE dbUser(
user_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL,
is_resc BOOLEAN DEFAULT FALSE,
is_admin BOOLEAN DEFAULT FALSE,
email VARCHAR(255) DEFAULT '',
phone BIGINT NOT NULL,
long DOUBLE PRECISION NOT NULL,
lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE item_category(
category_id SERIAL PRIMARY KEY,
category_name VARCHAR(255),
details VARCHAR(255)
);

CREATE TABLE items(
item_id SERIAL PRIMARY KEY,
iname VARCHAR(255),
quantity INTEGER DEFAULT 0,
category INTEGER REFERENCES item_category(category_id) NOT NULL,
details VARCHAR(255)
);


CREATE TABLE vehicles(
veh_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL,
long DOUBLE PRECISION NOT NULL,
lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE vehicle_load(
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
load INTEGER DEFAULT 1
);

CREATE TABLE vehicle_rescuers(
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL
);

CREATE TABLE base(
base_id SERIAL PRIMARY KEY,
lat DOUBLE PRECISION NOT NULL,
long DOUBLE PRECISION NOT NULL
);

CREATE TABLE base_inventory(
base_id INTEGER REFERENCES items(item_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE requests(
req_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT TRUE,
completed BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE DEFAULT NULL, -- NOT NULL, May not be assigned yet
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
long DOUBLE PRECISION NOT NULL,
lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE offers(
off_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT TRUE,
completed BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE DEFAULT NULL, --NOT NULL May not be assigned yet
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
long DOUBLE PRECISION NOT NULL,
lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE tasks(
tasks_id SERIAL PRIMARY KEY,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
off_id INTEGER REFERENCES offers(off_id),
req_id INTEGER REFERENCES requests(req_id),
completed BOOLEAN DEFAULT FALSE
);

CREATE TABLE news(
news_id SERIAL PRIMARY KEY,
descr VARCHAR(255),
base_id INTEGER REFERENCES base(base_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
req_id INTEGER REFERENCES requests(req_id) NOT NULL
);

CREATE INDEX dbuser_index ON dbUser(username);
CREATE INDEX items_index ON items(item_id);
CREATE INDEX bases_index ON base(base_id);
CREATE INDEX vehicle_index ON vehicles(veh_id);
CREATE INDEX tasks_index ON tasks(tasks_id);
CREATE INDEX offer_index ON offers(off_id);
CREATE INDEX tasks_index ON requests(req_id);

CREATE VIEW rescuer AS
    SELECT user_id, first_name, surname, username, pass
    FROM dbUser
    WHERE is_resc IS TRUE
    ;

CREATE VIEW baseadmin AS
    SELECT user_id, first_name, surname, username, pass
    FROM dbUser
    WHERE is_admin IS TRUE
    ;

--Need to add stored functions....