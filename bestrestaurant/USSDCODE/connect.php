<?php

// Database connection configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'restora';

try {
    // Create a PDO instance and set error mode to exception
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display an error message if connection fails
    die("ERROR: Could not connect. " . $e->getMessage());
}

?>
