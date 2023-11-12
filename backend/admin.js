import express from "express";
import cors from "cors";
import dotenv from "dotenv";
import db from "./database";
app.use(cors());
app.use(express.json());
dotenv.config();

// $$$ ADMIN $$$

//      1. Login–Logout
app.get("/login", async (req, res) => {
  try {
    const { username, pass } = req.params; //req.body ?
    let validate = db.query(
      "SELECT * FROM _user WHERE username=$1 AND pass=$2",
      [username, pass]
    );
    res.json(validate);
  } catch (err) {
    console.error(err.message);
  }
});

//      2. Base Management
//TODO:

//      3. Map Managemnet
//TODO:

//      4. Map Filtering
//TODO:

//      5. Stock View
//TODO:

//      6. Statistics
//TODO:

//      7. Rescuer's Account Creation
//TODO:

//      8. Announcement Creation
//TODO:
