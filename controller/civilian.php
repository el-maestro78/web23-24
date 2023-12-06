<?php
include("../model/config.php");
?>

<?php


//      1. Account Creation
//TODO:
$username;
$password;
$name;
$surname;
$phone;
$email;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])){
        echo "username is required";
    } elseif (empty($_POST["password"])) {
        echo "password is required";
    } elseif (empty($_POST["name"])){
            echo "name is required";
    } elseif (empty($_POST["surname"])) {
            echo "surname is required"; 
    } elseif (empty($_POST["phone"]))
            echo "phone is required"; 
    } elseif (empty($_POST["email"]))
        echo "phone is required";                 
    else {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $name = test_input($_POST["name"]);
        $surname = test_input($_POST["surname"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);

    }







//      2. Login-Logout
//same as admin's, no implementation needed here
$username;
$password;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])){
        echo "Name is required";
    } elseif (empty($_POST["password"])) {
        echo "Password is required";
    } else {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);

    }  

}

//      3. Request Handling
//TODO:
$Req_id;
$Off_id;
$Off_category;
$Civ_id;
$Req_category;
$NumOfCat;
$personNum;
$NumOfReq;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["category"])){
        echo "category is required";
    } elseif (empty($_POST["personNum"])) {
        echo "personNum is required";         
    } else {
        $Req_category = test_input($_POST["category"]);
        $personNum = test_input($_POST["personNum"]);
	$NumOfReq = $NumOfReq + 1;
     
    }   

}

if($NumOfCat>1)
{
echo "You can insert only one category per request.";
} else {
        $category = test_input($_POST["category"]);
        $personNum = test_input($_POST["personNum"]);
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

$Off_category = $Off_category;
$Off_category = $Off_category + 1;
}


for($Req_id = 0; $Req_id < 4; $Req_id++)
{
 
if($Reg_category != a AND $Reg_category != a+1)
{

echo"Req_category doesn't match with any Off_categories";
}

else
{
$Req_category = test_input($_POST["category"]);
$personNum = test_input($_POST["personNum"]);
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
$NumOfOff;
$Off_category;
$username;
$password;
$name;
$surname;
$phone;
$email;
$Off_quantity;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])){
        echo "username is required";
    } elseif (empty($_POST["password"])) {
        echo "password is required";
    } elseif (empty($_POST["name"])) {
            echo "name is required";
    } elseif (empty($_POST["surname"])) {
            echo "surname is required"; 
    } elseif (empty($_POST["phone"])) {
            echo "phone is required"; 
    } elseif (empty($_POST["email"])) {
        echo "phone is required";
    }  elseif (empty($_POST["Off_category"])) {
            echo "Off_category is required";
    } elseif (empty($_POST["Off_quantity"])) {
        echo "Off_quantity is required";
    }  
    
    }               
    else {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $name = test_input($_POST["name"]);
        $surname = test_input($_POST["surname"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
	$Off_category = test_input($_POST["email"]);
	$Off_quantity = test_input($_POST["email"]);

    }



for($Civ_id =3; $Civ_id <5; $Civ_id++)
{
 
if($NumofOff < 3)
 {
 echo "Please insert more offers.";
 }

}

?>
<?php
include("../model/dbclose.php");
?>