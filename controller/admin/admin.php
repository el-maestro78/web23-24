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
function add_item($item_name, $item_quant, $item_categ, $item_details){
    $item_name = validate_input($item_name);
    $item_quant = validate_input($item_quant);
    $item_categ = validate_input($item_categ);
    $item_details = validate_input($item_details);

    $sql = <<< EOF
            SELECT iname
            FROM item
            WHERE username={$item_name};
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
        }
    }   
}

function add_item_category($item_categ){
    $item_categ = validate_input($item_categ);

}
function load_json(){
        $url = 'http://usidas.ceid.upatras.gr/web/2023/';
        $export_url = 'http://usidas.ceid.upatras.gr/web/2023/export.php';
        update_item_quantity();
}

function update_item_quantity(){

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