<?php
include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['dish_id'])) {
    // Fetch the dish details from the database
    $dish_id = $_GET['dish_id'];
    $stmt = $conn->prepare("SELECT `dish_id`, `dish_name`, `dishphoto`, `description`, `price` FROM `dishes` WHERE `dish_id` = :dish_id");
    $stmt->bindParam(':dish_id', $dish_id);
    $stmt->execute();
    $dish = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$dish) {
        echo "Dish not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// If form is submitted, update the menu item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dish_name = $_POST['dish_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Perform update
    $stmt = $conn->prepare("UPDATE `dishes` SET `dish_name` = :dish_name, `description` = :description, `price` = :price WHERE `dish_id` = :dish_id");
    $stmt->bindParam(':dish_name', $dish_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':dish_id', $dish_id);
    
    if ($stmt->execute()) {
        echo "Dish updated successfully.";
    } else {
        echo "Error updating dish.";
    }
}
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Menu</title>
</head>
<body>
    <h2>Update Menu</h2>
    <form action="" method="POST">
        <label for="dish_name">Dish Name:</label><br>
        <input type="text" id="dish_name" name="dish_name" value="<?php echo $dish['dish_name']; ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $dish['description']; ?></textarea><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $dish['price']; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
