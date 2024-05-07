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
