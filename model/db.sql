-- First run this file
-- Then run the stored_funcs_and_triggers.sql
-- Last the insert.sql file
\c postgres;
DROP DATABASE webproject24;
CREATE DATABASE webproject24;

\c webproject24;
CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE TABLE dbUser(
    user_id SERIAL PRIMARY KEY,
    first_name VARCHAR(255) DEFAULT '',
    surname VARCHAR(255) DEFAULT '',
    username VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    is_resc BOOLEAN DEFAULT FALSE,
    is_admin BOOLEAN DEFAULT FALSE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone BIGINT NOT NULL,
    long DOUBLE PRECISION, --NOT NULL
    lat DOUBLE PRECISION -- NOT NULL
);

CREATE TABLE item_category(
    category_id SERIAL PRIMARY KEY,
    category_name VARCHAR(255) UNIQUE,
    details VARCHAR(255) DEFAULT ''
);

CREATE TABLE items(
    item_id SERIAL PRIMARY KEY,
    iname VARCHAR(255) UNIQUE,
    quantity INTEGER DEFAULT 0,
    category INTEGER REFERENCES item_category(category_id) ON DELETE CASCADE NOT NULL,
    details VARCHAR(255) DEFAULT ''
);

CREATE TABLE vehicles(
    veh_id SERIAL PRIMARY KEY,
    long DOUBLE PRECISION NOT NULL,
    lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE vehicle_load(
    veh_id INTEGER REFERENCES vehicles(veh_id) ON DELETE CASCADE NOT NULL,
    item_id INTEGER REFERENCES items(item_id) ON DELETE CASCADE NOT NULL,
    load INTEGER DEFAULT 1
);

CREATE TABLE vehicle_rescuers(
    veh_id INTEGER REFERENCES vehicles(veh_id) ON DELETE CASCADE NOT NULL,
    user_id INTEGER REFERENCES dbUser(user_id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE base(
    base_id SERIAL PRIMARY KEY,
    lat DOUBLE PRECISION NOT NULL,
    long DOUBLE PRECISION NOT NULL
);

CREATE TABLE requests(
    req_id SERIAL PRIMARY KEY,
    pending BOOLEAN DEFAULT TRUE,
    completed BOOLEAN DEFAULT FALSE,
    quantity INTEGER DEFAULT 1,
    reg_date DATE NOT NULL,
    assign_date DATE DEFAULT NULL,
    completed_date DATE DEFAULT NULL,
    user_id INTEGER REFERENCES dbUser(user_id) ON DELETE CASCADE NOT NULL,
    item_id INTEGER REFERENCES items(item_id) ON DELETE CASCADE NOT NULL,
    long DOUBLE PRECISION NOT NULL,
    lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE offers(
    off_id SERIAL PRIMARY KEY,
    pending BOOLEAN DEFAULT TRUE,
    completed BOOLEAN DEFAULT FALSE,
    quantity INTEGER DEFAULT 1,
    reg_date DATE NOT NULL,
    assign_date DATE DEFAULT NULL,
    completed_date DATE DEFAULT NULL,
    user_id INTEGER REFERENCES dbUser(user_id) ON DELETE CASCADE NOT NULL,
    item_id INTEGER REFERENCES items(item_id) ON DELETE CASCADE NOT NULL,
    long DOUBLE PRECISION NOT NULL,
    lat DOUBLE PRECISION NOT NULL
);

CREATE TABLE tasks(
    tasks_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES dbUser(user_id) ON DELETE CASCADE NOT NULL,
    veh_id INTEGER REFERENCES vehicles(veh_id) ON DELETE CASCADE NOT NULL,
    off_id INTEGER REFERENCES offers(off_id) ON DELETE CASCADE,
    req_id INTEGER REFERENCES requests(req_id) ON DELETE CASCADE,
    completed BOOLEAN DEFAULT FALSE
);

CREATE TABLE news(
    news_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    descr TEXT NOT NULL,
    date DATE NOT NULL,
    base_id INTEGER REFERENCES base(base_id) ON DELETE CASCADE NOT NULL,
    item_id INTEGER REFERENCES items(item_id) ON DELETE CASCADE NOT NULL
);

CREATE VIEW rescuer AS
    SELECT user_id, first_name, surname, username, pass
    FROM dbUser
    WHERE is_resc IS TRUE
    ;

CREATE VIEW base_admin AS
    SELECT user_id, first_name, surname, username, pass
    FROM dbUser
    WHERE is_admin IS TRUE
    ;

CREATE INDEX dbuser_index ON dbUser(username);
CREATE INDEX items_index ON items(item_id);
CREATE INDEX categories_index ON item_category(category_id);
CREATE INDEX bases_index ON base(base_id);
CREATE INDEX vehicle_index ON vehicles(veh_id);
CREATE INDEX tasks_index ON tasks(tasks_id);
CREATE INDEX offer_index ON offers(off_id);
CREATE INDEX requests_index ON requests(req_id);
CREATE INDEX vehicle_location_idx ON vehicles (lat, long);
CREATE INDEX base_location_idx ON base (lat, long);
CREATE INDEX request_location_idx ON requests (lat, long);
CREATE INDEX offer_location_idx ON offers (lat, long);
CREATE INDEX tasks_completed_idx ON tasks (completed);
CREATE INDEX requests_status_idx ON requests (pending, completed);
CREATE INDEX offers_status_idx ON offers (pending, completed);

