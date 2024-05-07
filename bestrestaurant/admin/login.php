<?php 
error_reporting(0);
session_start();
include("../connect.php");
try {
    if(isset($_POST["Login"])){
        if(empty($_POST["username"]) || empty($_POST["password"])) {
            $message = "<label>All field is required</label>";
        } else {
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";
            $statement = $conn->prepare($query);
            $statement->execute(array("username"=> $_POST["username"],"password"=> $_POST["password"])); 
            $count = $statement->rowCount();
            if($count > 0){
                $_SESSION["email"] = $_POST["email"];
                header("Location: index.php");
                exit();
            } else {
                $message = "<label>Username or Password is wrong</label>";
            }
        }
    }
} catch(PDOException $e) { 
    $message = $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENJOY RESTAURANT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        nav {
            background-color: #444;
            padding: 5px;
            text-align: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
        }
        nav a:hover {
            background-color: #555;
        }
        .container {
            margin: 20px auto;
            width: 80%;
            text-align: center;
        }
        form {
            display: inline-block;
            text-align: left;
        }
        footer{
            height: 100px;
            width: 100%;
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
    <header>
        <h1>ENJOY RESTAURANT</h1>
    </header>
   
    <div class="container">
       <h2>Login form</h2>
       <form method="POST">
     <h3>
        <label for="username">Username:</label><br>
        <input type="username" name="username"><br>
        <label for="Password">Password:</label><br>
        <input type="password" name="password"><br></h3>
        <button type="submit" name="Login" style="display: inline-block; margin-top: 10px; text-decoration: none; background-color: green; color: white; padding: 8px 15px; border-radius: 5px;">
        Login</button>
     <br><?php echo $message; ?><br></div>
     
 </form>


    </div>
    <br><br><br><br><br><br><br><br>
    <footer>
        <center>ALRIGHT RESERVED| ENJOY@2024</center>

    </footer>
</body>
</html>
