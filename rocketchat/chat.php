<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}

// Get the user ID of the user to chat with
$user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

// Mark messages from this user as read
$update_sql = "UPDATE messages SET read_status = 1 WHERE incoming_msg_id = {$_SESSION['unique_id']} AND outgoing_msg_id = {$user_id} AND read_status = 0";
mysqli_query($conn, $update_sql);

?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          } else {
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box"></div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <audio id="messageSentSound" src="php/sounds/sent.mp3" preload="auto"></audio>
  <audio id="messageReceivedSound" src="php/sounds/noti.mp3" preload="auto"></audio>

  <script src="javascript/notification.js"></script>
  <script src="javascript/chat.js"></script>
  <script>
      setInterval(() => {
          let xhr = new XMLHttpRequest();
          xhr.open("GET", "php/get-latest-message.php", true);
          xhr.onload = () => {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                  if (xhr.status === 200) {
                      let data = JSON.parse(xhr.responseText);
                      if (data.status === 'new') {
                          checkAndPlayNotificationSound(data.msg_id);
                      }
                  }
              }
          }
          xhr.send();
      }, 1000); // Check for new messages every 1 second
  </script>
</body>
</html>
