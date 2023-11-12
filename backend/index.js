//const express = require("express")
//const cors  = require("cors")
//const db = require("./db")
//require("dotenv").config()
import express from 'express';
import cors from "cors";
import dotenv from "dotenv";
import db from './database';

//const router = express.Router();
const app = express();
app.use(cors())
app.use(express.json())
dotenv.config();

app.listen(8000,() => {
    console.log("I am here guys")
})
//
//
//  ΔΕΝ ΓΡΑΦΟΥΜΕ ΣΕ ΑΥΤΟ ΤΟ ΑΡΧΕΙΟ ΠΡΟΣ ΤΟ ΠΑΡΟΝ
//
//
//

// search for @@@ for prototyping
// search for $$$ for admin's backend implemantation
// search for ### for rescuers's backend implemantation 
// search for %%% for civilian's backend implemantation

//              @@@  Routes Prototype @@@
app.get("/", async(req,res)=>{
    try{
        console.log(res);

    }catch(err){
        console.error(err.message)
    }
});


                // $$$ ADMIN $$$

//      1. Login–Logout
app.get("/login", async (req, res) => {
  try {
    const { username, pass } = req.params; //req.body ?
    let validate = db.query("SELECT * FROM _user WHERE username=$1 AND pass=$2",[username,pass])
    res.json(validate)

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






                // ### Rescuer ###
//      1. Login-Logout
    //same as admin's, no implementation needed here

//      2. Load Management
//TODO: 

//      2. Login-Logout
    //same as admin's, no implementation needed here

//      3. Map Viewing
//TODO: 

//      4. Map Filtering
    //same as admin's, no implementation needed here

//      5a. Completed
//TODO: 

//      5b. Cancelled
//TODO: 






                // %%% Civilian %%%
//      1. Account Creation
//TODO: 

//      2. Login-Logout
    //same as admin's, no implementation needed here

//      3. Request Handling
//TODO: 

//      4. Announcements & Offers
//TODO: 