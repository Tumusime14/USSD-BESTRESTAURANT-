<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BEST-REGISTER</title>
</head>
<body>
	<h1>BEST RESTAURANT</h1>
	<h4>Welcome here, this is form for new <br>
	users who wish eat within BEST RESTAURANT.</h4>
	<form action="newUser.php" method="POST">
		<label for="username">Username:</label><br>
        <input type="text" name="username" required> <br>
        <label for="emailAddress">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="Password">Password:</label><br>
        <input type="password" name="password" required><br>
        <button type="submit" name="Register" style="margin-top: 10px; background-color: blue; color: white; padding: 8px 15px; border-radius: 5px;">Register</button>
        <a href="index.php" style="display: inline-block; margin-top: 10px; text-decoration: none; background-color: red; color: white; padding: 8px 15px; border-radius: 5px;">Back</a>
     <p>Got account? 
        <button><a href="login.php">Login here</a></button></p>
	</form>

</body>
</html>