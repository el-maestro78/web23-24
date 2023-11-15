CREATE DATABASE webproject24;

CREATE TABLE civilian(
civ_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) DEFAULT '',
pass VARCHAR(255) DEFAULT '',
email VARCHAR(255) DEFAULT '',
);

CREATE TABLE rescuer (
resc_id SERIAL PRIMARY KEY,
first_name VARCHAR(255) DEFAULT '',
surname VARCHAR(255) DEFAULT '',
username VARCHAR(255) DEFAULT '',
pass VARCHAR(255) DEFAULT '',
email VARCHAR(255) DEFAULT '',
);

CREATE TABLE baseadmin (
admin_id SERIAL PRIMARY KEY,
base_loc ,
username VARCHAR(255) DEFAULT '',
pass VARCHAR(255) DEFAULT '',
email VARCHAR(255) DEFAULT '',
);

CREATE TABLE vehicles(

);

CREATE TABLE warehouse(

);

CREATE TABLE items(

);

CREATE TABLE requests(

);

CREATE TABLE news(

);

CREATE TABLE tasks(

);

CREATE TABLE offers(

);