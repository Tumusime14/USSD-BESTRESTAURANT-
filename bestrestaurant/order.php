<?php
include("connect.php");

// Check if dish_id is provided in the query parameter
if(isset($_GET['dish_id'])) {
    $dish_id = $_GET['dish_id'];

    // Fetch dish data from the database based on dish_id
    $stmt = $conn->prepare("SELECT `dish_name`, `price` FROM `dishes` WHERE `dish_id` = :dish_id");
    $stmt->bindParam(':dish_id', $dish_id);
    $stmt->execute();
    $dish = $stmt->fetch(PDO::FETCH_ASSOC);

    if($dish) {
        // Calculate total amount to pay based on the quantity ordered (assuming 1 for simplicity)
        $total_amount = $dish['price']; // Change this if you want to include quantity logic
        
        // Display food name and amount to pay
        echo "<h2>Order Details</h2>";
        echo "<p><strong>Food Name:</strong> " . $dish['dish_name'] . "</p>";
        echo "<p><strong>Amount to Pay:</strong> $" . number_format($total_amount, 2) . "</p>";

        // Add a Pay button
         echo "<a href="pending.php" class="pay-button">Pay</a>";
    } else {
        echo "Dish not found.";
    }
} else {
    echo "Invalid request.";
}

$conn = null;
?>
