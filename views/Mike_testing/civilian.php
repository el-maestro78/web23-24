<?php
include("../../model/config.php");
?>

<?php


//      1. Account Creation
//TODO:
$Civilian_username;
$Civilian_password;
$Civilian_name;
$Civilian_surname;
$Civilian_phone;
$Civilian_email;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Civilian_username"])){
        echo "username is required";
    } elseif (empty($_POST["Civilian_password"])) {
        echo "password is required";
    } elseif (empty($_POST["Civilian_name"])){
            echo "name is required";
    } elseif (empty($_POST["Civilian_surname"])) {
            echo "surname is required"; 
    } elseif (empty($_POST["Civilian_phone"]))
            echo "phone is required"; 
    } elseif (empty($_POST["Civilian_email"]))
        echo "email is required";                 
    else {
        $username = test_input($_POST["Civilian_username"]);
        $password = test_input($_POST["Civilian_password"]);
        $name = test_input($_POST["Civilian_name"]);
        $surname = test_input($_POST["Civilian_surname"]);
        $phone = test_input($_POST["Civilian_phone"]);
        $email = test_input($_POST["Civilian_email"]);

    }







//      2. Login-Logout
//same as admin's, no implementation needed here
$Civilian_username;
$Civilian_password;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Civilian_username"])){
        echo "Name is required";
    } elseif (empty($_POST["Civilian_password"])) {
        echo "Password is required";
    } else {
        $username = test_input($_POST["Civilian_username"]);
        $password = test_input($_POST["Civilian_password"]);

    }  

}

//      3. Request Handling
//TODO:
$Req_id;
$Off_id;
$Civilian_Off_category;
$Civ_id;
$Civilian_Req_category;
$Civilian_NumOfCat;
$Civilian_personNum;
$NumOfReq=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Req_category"])){
        echo "category is required";
    } elseif (empty($_POST["personNum"])) {
        echo "personNum is required";         
    } else {
        $category = test_input($_POST["Civilian_Req_category"]);
        $personNum = test_input($_POST["Civilian_personNum"]);
	$NumOfReq = $NumOfReq + 1;
		
     
    }   

}

if($NumOfCat>1)
{
echo "You can insert only one category per request.";
} else {
        $category = test_input($_POST["Civilian_Req_category"]);
        $personNum = test_input($_POST["Civilian_personNum"]);
	$NumOfReq = $NumOfReq + 1;
     
    }   


for($Civ_id = 0; $Civ_id < 3; $Civ_id++)
{

 if($NumOfReq < 4)
 {
 echo "Please insert more requests.";
 }

}

for($Off_id=0; $Off_id<2; $Off_id++)
{

$Civilian_Off_category = $Civilian_Off_category;
$Civilian_Off_category = $Civilian_Off_category + 1;
}


for($Req_id = 0; $Req_id < 4; $Req_id++)
{
 
if($Civilian_Reg_category != a AND $Reg_category != a+1)
{

echo"Req_category doesn't match with any Off_categories";
}

else
{
$category = test_input($_POST["Civilian_Req_category"]);
$personNum = test_input($_POST["Civilian_personNum"]);
$NumOfReq = $NumOfReq + 1;
}

}





function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }








//      4. Announcements & Offers
//TODO:
$Civ_id;
$Off_id;
$NumofCiv_id;
$NumOfOff=0;
$NumOfReq=0;
$Civilian_Off_category;
$Civilian_username;
$Civilian_password;
$Civilian_name;
$Civilian_surname;
$Civilian_phone;
$Civilian_email;
$Civilian_Off_quantity;
$Civilian_req
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Civilian_username"])){
        echo "username is required";
    } elseif (empty($_POST["Civilian_password"])) {
        echo "password is required";
    } elseif (empty($_POST["Civilian_name"])) {
            echo "name is required";
    } elseif (empty($_POST["Civilian_surname"])) {
            echo "surname is required"; 
    } elseif (empty($_POST["Civilian_phone"])) {
            echo "phone is required"; 
    } elseif (empty($_POST["Civilian_email"])) {
        echo "email is required";
    }  elseif (empty($_POST["Off_category"])) {
            echo "Off_category is required";
    } elseif (empty($_POST["Civilian_Off_quantity"])) {
        echo "Off_quantity is required";
    }  
    
    }               
    else {
        $username = test_input($_POST["Civilian_username"]);
        $password = test_input($_POST["Civilian_password"]);
        $name = test_input($_POST["Civilian_name"]);
        $surname = test_input($_POST["Civilian_surname"]);
        $phone = test_input($_POST["Civilian_phone"]);
        $email = test_input($_POST["Civilian_email"]);
	$Off_category = test_input($_POST["Civilian_Off_category"]);
	$Off_quantity = test_input($_POST["Civilian_Off_quantity"]);

    }



if(NumOfCiv_id <5)
{
echo "More Civ_id are required";
}


for($Civ_id =3; $Civ_id <6; $Civ_id++)
{
 
if($NumofOff < 3)
 {
 echo "Please insert more offers.";
 }

}

?>









<!DOCTYPE html>
<html>
<body>

<?php
$z; // Off_id
$y = "a"; // Off_category
$i; // Req_id
$k; // Req_category




for($z=0; $z<2; $z++)
{
 echo"y : $y <br>";
 $y++;
}

for($i=0; $i<2; $i++)
{

if($k != a AND $k != a+1)
{
echo"Req_category doesn't match with any Off_categories";
}


}


?>

</body>
</html>