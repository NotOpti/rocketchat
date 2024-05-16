<?php
session_start();
include_once "config.php";

if (isset($_SESSION['unique_id'])) {
    $user_id = $_SESSION['unique_id'];
    
    // Query to get the latest unread message
    $sql = "SELECT * FROM messages WHERE incoming_msg_id = {$user_id} AND read_status = 0 ORDER BY msg_id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        echo json_encode(['status' => 'new', 'msg_id' => $row['msg_id']]);
    } else {
        echo json_encode(['status' => 'none']);
    }
} else {
    echo json_encode(['status' => 'none']);
}
?>
