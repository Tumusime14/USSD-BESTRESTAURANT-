<?php
include("../connect.php");

// Check if dish_id is provided in the query parameter
if(isset($_GET['dish_id'])) {
    $dish_id = $_GET['dish_id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM `dishes` WHERE `dish_id` = :dish_id");
    $stmt->bindParam(':dish_id', $dish_id);

    if($stmt->execute()) {
        // Redirect back to the page showing dishes after deletion
        header("Location: menu.php");
        exit;
    } else {
        // Error handling
        echo "Error deleting dish.";
    }
} else {
    // Redirect to the page showing dishes if dish_id is not provided
    header("Location: menu.php");
    exit;
}
?>
