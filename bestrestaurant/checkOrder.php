<?php
// Include your database connection file
include("connect.php");

// Check if the order button is pressed and if the dish_id is provided
if(isset($_GET['dish_id'])) {
    // Get the dish_id from the query parameter
    $dish_id = $_GET['dish_id'];

    // Fetch dish data from the database based on dish_id
    $stmt = $conn->prepare("SELECT `dish_name`, `price` FROM `dishes` WHERE `dish_id` = :dish_id");
    $stmt->bindParam(':dish_id', $dish_id);
    $stmt->execute();
    $dish = $stmt->fetch(PDO::FETCH_ASSOC);

    if($dish) {
        // Insert the ordered item into the orderedfood table
        $insert_stmt = $conn->prepare("INSERT INTO `orderedfood` (`dish_name`, `price`) VALUES (:dish_name, :price)");
        $insert_stmt->bindParam(':dish_name', $dish['dish_name']);
        $insert_stmt->bindParam(':price', $dish['price']);
        $insert_stmt->execute();

        // Display success message
        echo "<h2>Order Placed Successfully</h2>";
        echo "<p>Your order for " . $dish['dish_name'] . " has been placed.</p>";
        echo "<p>Amount to Pay: $" . number_format($dish['price'], 2) . "</p>";
    } else {
        echo "Dish not found.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn = null;
?>
