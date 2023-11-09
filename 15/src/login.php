<?php
$users_file = $_SERVER['DOCUMENT_ROOT'] . '/db/users.csv';
$messages_file = $_SERVER['DOCUMENT_ROOT'] . '/db/messages.csv';
$user_dashboard_location = '/src/dashboards/user_dashboard.php';
$admin_dashboard_location = '/src/dashboards/admin_dashboard.php';
$signup_loc = '/src/signup.php';

if (isset($_POST['signup_redirect'])) {
  header('Location: ' . $signup_loc);
}

if (isset($_POST['submit'])) {
  if (!file_exists($users_file)) {
    echo 'File not found';
    return;
  }

  // if (isset($_COOKIE['login'])) {
  //   unset($_COOKIE['login']);
  //   setcookie('login', null, -1, '/');
  // }

  // if (isset($_COOKIE['last_msg_id'])) {
  //   unset($_COOKIE['last_msg_id']);
  //   setcookie('last_msg_id', null, -1, '/');
  // }

  // setcookie("login", "", time() - 3600);
  // setcookie("last_msg_id", "", time() - 3600);

  $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
  $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);

  $handle_read = fopen($users_file, 'r');
  $contents = fgetcsv($handle_read);
  fclose($handle_read);

  if ($contents === false) {
    echo 'No data';
    return;
  }

  $new_arr = array_chunk($contents, 3);

  foreach ($new_arr as $value) {
    if ($value[0] === $login && $value[1] === $pass) {
      session_start();
      $_SESSION['login'] = $value[0];
      setcookie('login', $value[0]);
      setcookie('name', $value[2]);
      // setcookie('last_msg_id', '-1');

      // Set cookie
      if (!file_exists($messages_file)) {
        header('Location: ' . $user_dashboard_location);
        return;
      }

      $handle_read = fopen($messages_file, 'r');
      $contents = fgetcsv($handle_read);
      fclose($handle_read);

      if ($contents === false) {
        header('Location: ' . $user_dashboard_location);
        return;
      }

      $new_arr = array_chunk($contents, 5);

      function getEntry($el)
      {
        $entry = [
          "id" => $el[0],
          "login" => $el[1],
          "name" => $el[2],
          "title" => $el[3],
          "date" => $el[4],
        ];
        return $entry;
      }

      $new_new_arr = array_map('getEntry', $new_arr);

      function filter_func($el)
      {
        return $el['login'] === $_SESSION['login'];
      }

      $filtered_arr = array_values(array_filter($new_new_arr, 'filter_func'));

      if (count($filtered_arr) > 0) {
        setcookie('last_msg_id', strval($filtered_arr[count($filtered_arr) - 1]['id']));
      }

      header('Location: ' . $user_dashboard_location);
      return;
    }
  }

  echo '<script>alert("User not found")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/style.css" />
  <script src="./login.js" defer></script>
  <title>Form</title>
</head>

<body>
  <h2>Login</h2>
  <main class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <section class="auth-block">
        <div class="input-container">
          <label for="login">Login</label>
          <input type="text" id="login" name="login" />
        </div>
        <div class="input-container">
          <label for="password">Password</label>
          <input type="password" id="password" name="pass" />
        </div>
      </section>
      <button type="submit" class="submit-btn" id="submit-btn" name="submit">Submit</button>
      <button type="submit" style="margin-top: 0.5rem;background-color: #fff;color: #333" class="submit-btn" name="signup_redirect">Signup</button>
    </form>
  </main>
</body>

</html>