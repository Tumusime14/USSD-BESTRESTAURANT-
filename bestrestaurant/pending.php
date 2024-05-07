<?php
include("connect.php");

try {
    // Check if dish_id is provided in the query parameter
    if(isset($_GET['dish_id'])) {
        $dish_id = $_GET['dish_id'];

        // Fetch dish data from the database based on dish_id
        $stmt = $conn->prepare("SELECT `dish_name`, `price` FROM `dishes` WHERE `dish_id` = :dish_id");
        $stmt->bindParam(':dish_id', $dish_id);
        $stmt->execute();
        $dish = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dish) {
            // Insert dish data into the pending table

            $stmt_pending = $conn->prepare("INSERT INTO pending (dish_id, foodname, price, status) VALUES (:dish_id, :foodname, :price, 'pending')");

            $stmt_pending->bindParam(':dish_id', $dish_id);
            $stmt_pending->bindParam(':foodname', $dish['dish_name']);
            $stmt_pending->bindParam(':price', $dish['price']);
            $stmt_pending->execute();

            echo "<h2>Order Placed Successfully</h2>";
            <script>

            </script>
            echo "<p><strong>Food Name:</strong> " . $dish['dish_name'] . "</p>";
            echo "<p><strong>Amount Paid:</strong> $" . number_format($dish['price'], 2) . "</p>";
            echo "<p>Thank you for your order!</p>";
        } else {
            echo "Dish not found.";
        }
    } else {
        echo "Invalid request.";
    }
} catch(PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
