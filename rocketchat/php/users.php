<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

$outgoing_id = $_SESSION['unique_id'];
$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
$query = mysqli_query($conn, $sql);

$output = "";

if (mysqli_num_rows($query) == 0) {
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($query) > 0) {
    include_once "data.php";
} else {
    // Handle unexpected result
    $output .= "Unexpected error occurred";
}

echo $output;
?>
