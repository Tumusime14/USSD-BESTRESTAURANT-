<?php 
session_start();
include("connect.php");

if(isset($_POST["Register"])){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "INSERT INTO users(username,email,password) VALUES (:username, :email,:password)";
    $query_run = $conn->prepare($query);

    $data = [
        ":username"=> $username,
        ":email"=> $email,
        ":password"=> $password,
    ];
    $query_excuter = $query_run->execute($data);
    if($query_excuter) {
        $_SESSION["message"] = "Registered successfully";
        header("Location: index.php");
        exit(0);

} else {
    $_SESSION["message"] = "Failled to register";
    header("Location: index.php");
    exit(0);
}
}
?>