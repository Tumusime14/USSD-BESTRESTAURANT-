<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BESTRESTO</title>
</head>
<body>
    <h2>Add New Dish</h2>
    <form action="insert_dish.php" method="POST" enctype="multipart/form-data">
        <label for="dish_name">Dish Name:</label><br>
        <input type="text" id="dish_name" name="dish_name" required><br><br>

        <label for="dish_photo">Dish Photo:</label><br>
        <input type="file" id="dish_photo" name="dish_photo" accept="image/*" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" min="0" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>