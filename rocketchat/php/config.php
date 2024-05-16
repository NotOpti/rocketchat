<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "chatapp";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    echo "Database connection error: " . mysqli_connect_error();
}

$activation_key = "4201337"; // Define your activation key here
?>
