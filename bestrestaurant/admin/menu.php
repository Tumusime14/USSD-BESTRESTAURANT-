<?php
include("../connect.php");

// Fetch dishes data from the database
$stmt = $conn->prepare("SELECT `dish_id`, `dish_name`, `dishphoto`, `description`, `price` FROM `dishes`");
$stmt->execute();
$dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dishes</title>
    <style>
.header {
  background: rgba(0, 0, 0, 0.5);
  color: #ffffff;
  text-align: center;
  padding: 15px;
}
        .dish-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .dish-item {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .dish-photo {
            max-width: 100%;
            height: auto;
        }
        .update-button,
        .delete-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #dc3545;
        }
 .footer {
  background-color: black;
  color: #ffffff;
  text-align: center;
  font-size: 14px;
  padding: 15px;
}
    </style>
</head>
<body>
<div class="header">
  <h1>BEST RESTAURANT / ADMIN</h1>
</div>
    <h2>Dishes</h2>
    <h4><a href="index.php">HOME</a></h4>
    <div class="dish-container">
        <?php foreach ($dishes as $dish): ?>
            <div class="dish-item">
                <img class="dish-photo" src="<?php echo $dish['dishphoto']; ?>" alt="<?php echo $dish['dish_name']; ?>">
                <h3><?php echo $dish['dish_name']; ?></h3>
                <p><strong>Description:</strong> <?php echo $dish['description']; ?></p>
                <p><strong>Price:</strong> RWF <?php echo number_format($dish['price'], 2); ?></p>
                <a href="update_menu.php?dish_id=<?php echo $dish['dish_id']; ?>" class="update-button">Update Menu</a>
                <a href="delete_dish.php?dish_id=<?php echo $dish['dish_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this dish?')">Delete</a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="footer">
  <p>ALRIGHT RESERVED| ENJOY@2024.</p>
</div>
</body>
</html>
