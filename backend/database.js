//const { password } = require("pg/lib/defaults");

//const pg = require("pg").Pool;
import pg from "pg";
//const { Pool } = pg;


const pool = new pg({
    user: "postgres",
    password: process.env.PASS,
    host: "localhost",
    port:5432,
    database: "webproject"
});

module.exports = pool;