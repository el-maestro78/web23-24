<?php
session_start();
include 'db_connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function displayAnnouncements($conn) {
    $sql = "SELECT * FROM announcements";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h2>Announcements</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><b>" . $row['ann_title'] . ":</b> " . $row['ann_description'] . " (Date: " . $row['ann_date'] . ") ";
            echo "<form method='POST' action=''>
                    <input type='hidden' name='announcement_id' value='" . $row['ann_id'] . "'>
                    <input type='text' name='item' placeholder='Προϊόν' required>
                    <input type='number' name='quantity' placeholder='Quantity' required>
                    <input type='submit' name='submit_offer' value='Offer'>
                  </form>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "There are no announcements.";
    }
}


if (isset($_POST['submit_offer'])) {
    $announcement_id = $_POST['announcement_id'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    
    $sql = "INSERT INTO offers (user_id, announcement_id, item, quantity, status, date_created) VALUES (?, ?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $user_id, $announcement_id, $item, $quantity);
    
    if ($stmt->execute()) {
        echo "Your offer has successfully registered.";
    } else {
        echo "Error when registering the offer.";
    }
    
    $stmt->close();
}


function displayUserOffers($conn, $user_id) {
    $sql = "SELECT o.id, a.ann_title, o.item, o.quantity, o.status, o.date_created, o.date_accepted 
            FROM offers o
            JOIN announcements a ON o.announcement_id = a.ann_id
            WHERE o.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<h2>My offers.</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><b>" . $row['ann_title'] . ":</b> " . $row['item'] . " (Quantity: " . $row['quantity'] . ", Condition: " . $row['status'] . ")";
            if ($row['status'] == 'pending') {
                echo " <form method='POST' action=''>
                        <input type='hidden' name='offer_id' value='" . $row['id'] . "'>
                        <input type='submit' name='cancel_offer' value='Cancellation'>
                       </form>";
            }
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "No offer has been submitted.";
    }
    
    $stmt->close();
}

if (isset($_POST['cancel_offer'])) {
    $offer_id = $_POST['offer_id'];
    
    $sql = "DELETE FROM offers WHERE id = ? AND user_id = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offer_id, $user_id);
    
    if ($stmt->execute()) {
        echo "Your offer has successfully cancelled.";
    } else {
        echo "Error canceling offer.";
    }
    
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Offer control</title>
</head>
<body>

<?php

displayAnnouncements($conn);

displayUserOffers($conn, $user_id);
?>

</body>
</html>

<?php
$conn->close();
?>