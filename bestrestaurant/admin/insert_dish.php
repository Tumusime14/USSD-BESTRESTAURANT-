<?php
include("../connect.php");
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO dishes (dish_name, dishphoto, description, price) VALUES (:dish_name, :dish_photo, :description, :price)");

    // Bind parameters
    $stmt->bindParam(':dish_name', $dish_name);
    $stmt->bindParam(':dish_photo', $dish_photo);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);

    // Assign values from the form submission
    $dish_name = $_POST['dish_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["dish_photo"]["name"]);
    move_uploaded_file($_FILES["dish_photo"]["tmp_name"], $target_file);
    $dish_photo = $target_file;

    // Execute the prepared statement
    $stmt->execute();

    echo "New record created successfully";
    header("Location: index.php");

$conn = null;
?>
