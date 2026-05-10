<?php
$servername = "localhost";
$username = "root"; // Default XAMPP user
$password = "";     // Default XAMPP password is empty
$dbname = "careflow";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>