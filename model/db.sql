CREATE DATABASE webproject24;

CREATE TYPE base_coordinates AS (
    x DOUBLE PRECISION,
    y DOUBLE PRECISION
);

CREATE TABLE civilian(
civ_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) NOT NULL,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT ''
);

CREATE TABLE rescuer (
resc_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) NOT NULL,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT ''
);

CREATE TABLE baseadmin (
admin_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL,
pass VARCHAR(255) NOT NULL,
email VARCHAR(255) DEFAULT ''
);

CREATE TABLE vehicles(
veh_id SERIAL PRIMARY KEY,
username VARCHAR(255) NOT NULL,
location base_coordinates NOT NULL,
resc_id INTEGER REFERENCES rescuer(resc_id)
);

CREATE TABLE base(
base_id SERIAL PRIMARY KEY,
location base_coordinates NOT NULL,
);

CREATE TABLE items(
item_id SERIAL PRIMARY KEY,
subcategory INTEGER NOT NULL,
details json,
);

CREATE TABLE news(
news_id SERIAL PRIMARY KEY,
);

CREATE TABLE tasks(
tasks_id SERIAL PRIMARY KEY,
);

CREATE TABLE requests(
req_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE NOT NULL,
civ_id INTEGER REFERENCES civilian(civ_id)
);

CREATE TABLE offers(
off_id SERIAL PRIMARY KEY,
pending BOOLEAN DEFAULT FALSE,
quantity INTEGER DEFAULT 1,
reg_date DATE NOT NULL,
assign_date DATE NOT NULL,
civ_id INTEGER REFERENCES civilian(civ_id)
);