<?php
$file = $_SERVER['DOCUMENT_ROOT'] . '/db/data.csv';

$player_dashboard_loc = '/src/dashboards/player_dashboard.php';
$admin_dashboard_loc = '/src/dashboards/admin_dashboard.php';
$login_loc = '/src/login.php';

session_start();

if (!isset($_SESSION['role'])) {
  header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $login_loc);
}

if ($_SESSION['role'] === 'player') {
  header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $player_dashboard_loc);
}

if (isset($_POST['submit'])) {
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
  $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
  $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
  $input_file = '-';
  $role = 'player';

  if (!file_exists($file)) {
    $handle = fopen($file, 'w');
    fclose($handle);
  }

  $handle_read = fopen($file, 'r');
  $contents = fgetcsv($handle_read);
  fclose($handle_read);

  if ($contents === false) {
    if (!empty($_FILES['image']['name'])) {
      $allowed_ext = ['png', 'jpg', 'jpeg'];
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/upload/{$file_name}";

      $file_ext = explode('.', $file_name);
      $file_ext = strtolower(end($file_ext));

      if (in_array($file_ext, $allowed_ext)) {
        if ($file_size < 1000000) {
          move_uploaded_file($tmp_name, $target_dir);
          $input_file = $target_dir;
        }
      }
    }

    $handle_write = fopen($file, 'w');
    fputcsv($handle_write, [$name, $login, $pass, $email, $country, $input_file, $role]);
    fclose($handle_write);

    echo '<script>alert("Posted successfully")</script>';

    header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $admin_dashboard_loc);
    return;
  }

  $new_arr = array_chunk($contents, 7);

  $is_entry_found = false;

  foreach ($new_arr as $key => $value) {
    if ($value[1] === $login) {
      // Exception: entry already exists
      echo "<script>alert('Entry already exists')</script>";
      $is_entry_found = true;
      // header("Location: {$_SERVER['PHP_SELF']}");
      // die();
      // return;
    }
  }

  if (!$is_entry_found) {
    if (!empty($_FILES['image']['name'])) {
      $allowed_ext = ['png', 'jpg', 'jpeg'];
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $tmp_name = $_FILES['image']['tmp_name'];
      $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/upload/{$file_name}";

      $file_ext = explode('.', $file_name);
      $file_ext = strtolower(end($file_ext));

      if (in_array($file_ext, $allowed_ext)) {
        if ($file_size < 1000000) {
          move_uploaded_file($tmp_name, $target_dir);
          $input_file = $target_dir;
        }
      }
    }

    array_push($new_arr, [$name, $login, $pass, $email, $country, $input_file, $role]);

    $new_new_arr = array_merge(...$new_arr);

    $handle_write = fopen($file, 'w');
    fputcsv($handle_write, $new_new_arr);
    fclose($handle_write);

    echo '<script>alert("Posted successfully")</script>';

    // session_start();
    // $_SESSION['role'] = 'player';
    header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $admin_dashboard_loc);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../assets/style.css" />
  <script src="./post_form.js" defer></script>
  <title>Form</title>
</head>

<body>
  <h2>Post User</h2>
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
      <section class="misc-block">
        <div class="input-container">
          <label for="file">File</label>
          <input type="file" id="file" name="image" />
        </div>
        <div class="input-container">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" />
        </div>
        <div class="input-container">
          <label for="country">Country</label>
          <select id="country" class="country-select" name="country">
            <option value="none">None</option>
            <option value="belarus">Belarus</option>
            <option value="poland">Poland</option>
            <option value="france">France</option>
            <option value="united kingdom">United Kingdom</option>
            <option value="united states">United States</option>
          </select>
        </div>
      </section>
      <button type="submit" class="submit-btn" id="submit-btn" name="submit">Submit</button>
    </form>
  </main>
</body>

</html>