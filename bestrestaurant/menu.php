<?php
include("connect.php");

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

* {
  box-sizing: border-box;
}
.dish-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
.header {
  background: rgba(0, 0, 0, 0.5);
  color: #ffffff;
  text-align: center;
  padding: 15px;
}
        .dish-item {
            border: 1px solid #ccc;
            padding: 10px;
        }
        .dish-photo {
            max-width: 100%;
            height: auto;
        }
        .order-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
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
  <h1>BEST RESTAURANT</h1>
</div>
    <h2>Dishes</h2>
    <h3><a href="index.php">Back Home</a></h3>
    <div class="dish-container">
        <?php foreach ($dishes as $dish): ?>
            <div class="dish-item">
                <img class="dish-photo" src="<?php echo $dish['dishphoto']; ?>" alt="<?php echo $dish['dish_name']; ?>">
                <h3><?php echo $dish['dish_name']; ?></h3>
                <p><strong>Description:</strong> <?php echo $dish['description']; ?></p>
                <p><strong>Price:</strong> Rwf <?php echo number_format($dish['price'], 2); ?></p>
                <p>Address: <input type="text" id="address" name="phone"></p>
                <a href="pending.php?dish_id=<?php echo $dish['dish_id']; ?>" class="order-button">Order</a>

            </div>
        <?php endforeach; ?>
    </div>
    <div class="footer">
  <p>ALRIGHT RESERVED| ENJOY@2024.</p>
</div>
</body>
</html>
