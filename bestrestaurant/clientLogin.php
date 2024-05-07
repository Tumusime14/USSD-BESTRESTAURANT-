<?php 
error_reporting(0);
session_start();
include("connect.php");
try {
    if(isset($_POST["Login"])){
        if(empty($_POST["email"]) || empty($_POST["password"])) {
            $message = "<label>All field is required</label>";
        } else {
            $query = "SELECT * FROM users WHERE email = :email AND password = :password";
            $statement = $conn->prepare($query);
            $statement->execute(array("email"=> $_POST["email"],"password"=> $_POST["password"])); 
            $count = $statement->rowCount();
            if($count > 0){
                $_SESSION["email"] = $_POST["email"];
                header("Location: index.php");
                exit();
            } else {
                $message = "<label>Email or Password is wrong</label>";
            }
        }
    }
} catch(PDOException $e) { 
    $message = $e->getMessage();
}
?>

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
	
	 <form method="POST">
     <h3>
        <label for="Email_Address">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="Password">Password:</label><br>
        <input type="password" name="password" required><br></h3>
        <button type="submit" name="Login" style="display: inline-block; margin-top: 10px; text-decoration: none; background-color: green; color: white; padding: 8px 15px; border-radius: 5px;">
        Login</button>
     <a href="register.php" style="display: inline-block; margin-top: 10px; text-decoration: none; background-color: #007bff; color: white; padding: 8px 15px; border-radius: 5px;">Register</a>
     
     <a href="index.php" style="display: inline-block; margin-top: 10px; text-decoration: none; background-color: red; color: white; padding: 8px 15px; border-radius: 5px;">Back</a>
     <br><?php echo $message; ?><br></div>
     
 </form>

</body>
</html>