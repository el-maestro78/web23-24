<?php
    include("../../model/config.php");
?>

<?php
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



//      1. Login–Logout
function login($username, $password){    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])){
            echo "Name is required";
        //} elseif (empty($_POST["password"])) { // Maybe for 
        //   echo "Password is required";
        } else {
            $username = validate_input($_POST["username"]);
            $password = validate_input($_POST["password"]);
        }
        $sql = <<< EOF
          SELECT username, pass 
          FROM dbUser 
          WHERE username={$username} AND pass={$password};
        EOF;
        // if(pg_num_rows($dbconn, $sql) > 0){
        //      echo "Logged in";
        // }
        $result = pg_query($dbconn, $sql);

        if ($result && pg_num_rows($result) > 0) {
            // Authentication successful
            $_SESSION["username"] = $username;
            header("Location: dashboard.php"); // Redirect to the dashboard or another page
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    }
}

//      2. Base Management
function update_item($item_name, $item_quant=0, $item_categ='', $item_details='', $action){
    $item_name = validate_input($item_name);
    $item_quant = validate_input($item_quant);
    $item_categ = validate_input($item_categ);
    $item_details = validate_input($item_details);
    $action = validate_input($action);
    switch ($action) {
        case "insert":
            add_item($item_name, $item_quant, $item_categ, $item_details);
            break;
        case "remove":
            remove_item($item_name);
            break;
        case "details":
            details_item($item_name, $item_details);
            break;
        case "quantity":
            quantity_item($item_name, $item_quant);
            break;    
        default:
            echo "Error with $action for $item_categ";
    }
}

function add_item($item_name, $item_quant, $item_categ, $item_details=''){
    $sql = <<< EOF
            SELECT iname
            FROM item
            WHERE iname=$item_name;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0){
        echo "Item $item_name already exists";
    }
    else{
        if ($item_quant <= 0) {
            $item_quant == 0;
        }
        $sql = <<< EOF
            INSERT INTO items(iname, quantity, category, details) 
            VALUES ($item_name, $item_quant, $item_categ, $item_details)";
        EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with item $item_name";
            echo $error_message;
        }
    }   
}
function remove_item($item_name){
    $sql = <<< EOF
            SELECT iname
            FROM items
            WHERE iname = $item_name;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item $item_name doesn't exist";
    } else {

        $sql = "DELETE FROM items WHERE iname = $item_name";
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with deleting item $item_name";
            echo $error_message;
        }
    }
}

function details_item($item_name, $item_details){
    $sql = <<< EOF
            SELECT iname
            FROM items
            WHERE iname = $item_name;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item $item_name doesn't exist";
    } else {

        $sql = <<< EOF
            "UPDATE items 
            SET details = $item_details
            WHERE iname = $item_name";
        EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with updating details for item $item_categ";
            echo $error_message;
        }
    }
}

function quantity_item($item_name, $item_quant){
    $sql = <<< EOF
            SELECT iname
            FROM items
            WHERE iname = $item_name;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item $item_name doesn't exist";
    } else {

        $sql = <<< EOF
            "UPDATE items 
            SET quantity = $item_quant
            WHERE iname = $item_name";
        EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with updating quantity for item $item_categ";
            echo $error_message;
        }
    }
}


function update_item_category($item_categ, $categ_details = "", $action){
    $item_categ = validate_input($item_categ);
    $categ_details = validate_input($categ_details);
    $action = validate_input($action);
    switch($action){
        case "insert":
            add_item_category($item_categ, $categ_details);
            break;
        case "remove":
            remove_item_category($item_categ);
            break;
        case "details":
            details_item_category($item_categ, $categ_details);
            break;
        default:
            echo "Error with $action for $item_categ";
    }
}
function add_item_category($item_categ, $categ_details = ""){
    $sql = <<< EOF
            SELECT category_name
            FROM item_category
            WHERE category_name = $item_categ;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0) {
        echo "Item category $item_categ already exists";
    } else {

        $sql = <<< EOF
                INSERT INTO item_category(category_name, details) 
                VALUES ($item_categ, $categ_details)";
            EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with insert category $item_categ";
            echo $error_message;
        }
    }
}
function remove_item_category($item_categ){
    $sql = <<< EOF
            SELECT category_name
            FROM item_category
            WHERE category_name = $item_categ;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item category $item_categ doesn't exist";
    } else {

        $sql = "DELETE FROM item_category WHERE category_name = $item_categ";
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with deleting category $item_categ";
            echo $error_message;
        }
    }
}

function details_item_category($item_categ, $categ_details){
    $sql = <<< EOF
            SELECT category_name
            FROM item_category
            WHERE category_name = $item_categ;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item category $item_categ doesn't exist";
    } else {

        $sql = <<< EOF
            "UPDATE item_category 
            SET details = $categ_details
            WHERE category_name = $item_categ";
        EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with updating details for category $item_categ";
            echo $error_message;
        }
    }
}


function load_json(){ // TODO, το link δεν λειτουργει...
        $url = 'http://usidas.ceid.upatras.gr/web/2023/';
        $export_url = 'http://usidas.ceid.upatras.gr/web/2023/export.php';
        update_item_quantity();
}

//      3. Map Managemnet
//TODO:
function load_markers(){
    //for base in bases:
    
}

function load_vehicles(){

}


function load_requests(){


}

function load_offers()
{


}

function drag_n_drop_base(){

}


//      4. Map Filtering
//TODO:
function filter(){
    
}

//      5. Stock View
//TODO: Create html array for database, filtered by subcategory


//      6. Statistics
//TODO:

//      7. Rescuer's Account Creation
//TODO:

//      8. Announcement Creation
//TODO:


?>
<?php
    include("../../model/dbclose.php");
?>