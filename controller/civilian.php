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
$category;
$NumOfCat;
$personNum;
$NumOfReq;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["category"])){
        echo "category is required";
    } elseif (empty($_POST["personNum"])) {
        echo "personNum is required";         
    } else {
        $category = test_input($_POST["category"]);
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


if($NumOfReq < 4)
{
echo "Please insert more requests.";
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
$NumOfOff;
$category;
$username;
$password;
$name;
$surname;
$phone;
$email;
$quantity;
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
    }  elseif (empty($_POST["category"])) {
            echo "category is required";
    } elseif (empty($_POST["quantity"])) {
        echo "quantity is required";
    }  
    
    }               
    else {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
        $name = test_input($_POST["name"]);
        $surname = test_input($_POST["surname"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
	$category = test_input($_POST["email"]);
	$quantity = test_input($_POST["email"]);

    }




if($NumofOff < 3)
{
echo "Please insert more offers.";
}


?>
<?php
include("../model/dbclose.php");
?>