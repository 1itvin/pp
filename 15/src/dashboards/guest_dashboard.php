<?php
$player_dashboard_loc = '/src/dashboards/player_dashboard.php';
$login_loc = '/src/login.php';
$logout_loc = '/src/logout.php';
$get_form = '/src/admin_forms/get_form.php';
$post_form = '/src/admin_forms/post_form.php';
$update_form = '/src/admin_forms/update_form.php';
$delete_form = '/src/admin_forms/delete_form.php';

session_start();

// if (!isset($_SESSION['login'])) {
//   header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $login_loc);
// }

if (isset($_POST['login_redirect'])) {
  header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $login_loc);
}

// if (isset($_POST['get_user'])) {
//   header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $get_form);
// }

// if (isset($_POST['post_user'])) {
//   header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $post_form);
// }

// if (isset($_POST['update_user'])) {
//   header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $update_form);
// }

// if (isset($_POST['delete_user'])) {
//   header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $delete_form);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/user_dashboard.css">
  </link>
  <!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script> -->
  <!-- <script src="./guest_dashboard.js" defer></script> -->
  <title>Document</title>
</head>

<body>
  <main>
    <div class="chat">
      <div class="messages-container">
        <ul class="messages-list" id="messages-list"></ul>
      </div>
      <!-- <div class="controls">
        <input type="text" id="msg-input">
        <button type="button" id="submit-btn">Send</button>
      </div> -->
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <button class="submit-btn" type="submit" name="login_redirect">Login</button>
    </form>
  </main>
</body>

</html>