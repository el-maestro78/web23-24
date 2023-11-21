CREATE DATABASE webproject24;

\c webproject24;

CREATE TYPE coordinates AS (
    x DOUBLE PRECISION,
    y DOUBLE PRECISION
);

CREATE TABLE civilian(
civ_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT '',
phone BIGINT NOT NULL,
loc coordinates
);

CREATE TABLE rescuer (
resc_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT ''
);

CREATE TABLE baseadmin (
admin_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT ''
);

CREATE TABLE items(
item_id SERIAL PRIMARY KEY,
iname VARCHAR(255),
category INTEGER NOT NULL,
details VARCHAR[]
);

CREATE TABLE vehicles(
veh_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL,
loc coordinates NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
resc_id INTEGER REFERENCES rescuer(resc_id) NOT NULL
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
civ_id INTEGER REFERENCES civilian(civ_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE offers(
off_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE NOT NULL,
civ_id INTEGER REFERENCES civilian(civ_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL
);

CREATE TABLE tasks(
tasks_id SERIAL PRIMARY KEY,
resc_id INTEGER REFERENCES rescuer(resc_id) NOT NULL,
veh_id INTEGER REFERENCES vehicles(veh_id) NOT NULL,
off_id INTEGER REFERENCES offers(off_id) NOT NULL,
req_id INTEGER REFERENCES requests(req_id) NOT NULL
);

CREATE TABLE news(
news_id SERIAL PRIMARY KEY,
descr VARCHAR(255),
base_id INTEGER REFERENCES base(base_id) NOT NULL,
item_id INTEGER REFERENCES items(item_id) NOT NULL,
req_id INTEGER REFERENCES requests(req_id) NOT NULL
);