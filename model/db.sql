CREATE DATABASE webproject24;

\c webproject24;

CREATE TYPE coordinates AS (
    x DOUBLE PRECISION,
    y DOUBLE PRECISION
);
--μήπως να χρησιμοποιήσουμε γεκίκευση/ εξειδίκευση, δλδ dbUser και εξειδικέυσεις
--resc, admin, citizen, στην περίπτωση που χρειαστεί να προσθέσουμε σε κάποιον κάποιο 
--και όχι στους άλλους, και να μπορεί να ξεχωρισθεί όταν χρειάζεται σε συσχετήσεις
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