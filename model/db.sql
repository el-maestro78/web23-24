CREATE DATABASE webproject24;

\c webproject24;

CREATE TYPE coordinates AS (
    x DOUBLE PRECISION,
    y DOUBLE PRECISION
);

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
loc coordinates
);

CREATE TABLE item_category(
category_id SERIAL PRIMARY KEY,
category_name VARCHAR(255),
details VARCHAR[]
);

CREATE TABLE items(
item_id SERIAL PRIMARY KEY,
iname VARCHAR(255),
quantity INTEGER DEFAULT 0,
category INTEGER REFERENCES item_category(category_id) NOT NULL,
details VARCHAR[]
);


CREATE TABLE vehicles(
veh_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL,
loc coordinates NOT NULL,
);

CREATE TABLE vehicle_load(
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE vehicle_rescuers(
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL
);

CREATE TABLE base(
base_id SERIAL PRIMARY KEY,
loc coordinates NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE requests(
req_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE NOT NULL,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE offers(
off_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE NOT NULL,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE tasks(
tasks_id SERIAL PRIMARY KEY,
user_id INTEGER REFERENCES dbUser(user_id) NOT NULL,
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
off_id INTEGER REFERENCES offers(off_id),
req_id INTEGER REFERENCES requests(req_id)
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
