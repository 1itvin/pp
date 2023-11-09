<?php
$users_file = $_SERVER['DOCUMENT_ROOT'] . '/db/users.csv';
$user_dashboard_location = '/src/dashboards/user_dashboard.php';
$login_loc = '/src/login.php';

if (isset($_POST['login_redirect'])) {
  header('Location: ' . $login_loc);
}

if (isset($_POST['submit'])) {
  // setcookie("login", "", time() - 3600);
  // setcookie("last_msg_id", "", time() - 3600);

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
  $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);

  if (!file_exists($users_file)) {
    $handle = fopen($users_file, 'w');
    fclose($handle);
  }

  $handle_read = fopen($users_file, 'r');
  $contents = fgetcsv($handle_read);
  fclose($handle_read);

  if ($contents === false) {
    $handle_write = fopen($users_file, 'w');
    fputcsv($handle_write, [$login, $pass, $name]);
    fclose($handle_write);

    echo '<script>alert("Posted successfully")</script>';

    session_start();
    $_SESSION['login'] = $login;
    setcookie('login', $login);
    setcookie('name', $name);
    // $_SESSION['role'] = 'user';
    header('Location: ' . $user_dashboard_location);
    return;
  }

  $new_arr = array_chunk($contents, 3);

  $is_entry_found = false;

  foreach ($new_arr as $key => $value) {
    if ($value[0] === $login) {
      echo "<script>alert('User already exists')</script>";
      $is_entry_found = true;
    }
  }

  if (!$is_entry_found) {
    array_push($new_arr, [$login, $pass, $name]);

    $new_new_arr = array_merge(...$new_arr);

    $handle_write = fopen($users_file, 'w');
    fputcsv($handle_write, $new_new_arr);
    fclose($handle_write);

    echo '<script>alert("Posted successfully")</script>';

    session_start();
    $_SESSION['login'] = $login;
    setcookie('login', $login);
    setcookie('name', $name);
    header('Location: ' . $user_dashboard_location);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../assets/style.css" />
  <script src="./signup.js" defer></script>
  <title>Form</title>
</head>

<body>
  <h2>Sign Up</h2>
  <main class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <section class="auth-block">
        <div class="input-container">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" />
        </div>
        <div class="input-container">
          <label for="login">Login</label>
          <input type="text" id="login" name="login" />
        </div>
        <div class="input-container">
          <label for="password">Password</label>
          <input type="password" id="password" name="pass" />
        </div>
        <div class="input-container">
          <label for="password-confirm">Password Confirm</label>
          <input type="password" id="password-confirm" />
        </div>
      </section>
      <button type="submit" class="submit-btn" id="submit-btn" name="submit">Submit</button>
      <button type="submit" style="margin-top: 0.5rem;background-color: #fff;color: #333" class="submit-btn" name="login_redirect">Login</button>
    </form>
  </main>
</body>

</html>