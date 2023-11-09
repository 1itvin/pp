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
  // $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
  $input_file = '-';

  if (!file_exists($file)) {
    echo 'File not found';
    return;
  }

  $handle_read = fopen($file, 'r');
  $contents = fgetcsv($handle_read);
  fclose($handle_read);

  if ($contents === false) {
    echo 'No data';
    return;
  }

  $new_arr = array_chunk($contents, 6);

  $is_entry_found = false;

  foreach ($new_arr as $key => $value) {
    if ($value[1] === $login) {
      $new_arr[$key][0] = $name;
      $new_arr[$key][3] = $email;
      $new_arr[$key][4] = $country;
      $new_arr[$key][5] = $file;

      $is_entry_found = true;
    }
  }

  if (!$is_entry_found) {
    echo "<script>alert('No entry found')</script>";
  } else {
    $handle_write = fopen($file, 'w');
    $new_new_arr = array_merge(...$new_arr);
    fputcsv($handle_write, $new_new_arr);
    fclose($handle_write);

    echo "<script>alert('Entry updated')</script>";
  }

  // header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $admin_dashboard_loc);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../../assets/style.css" />
  <script src="./update_form.js" defer></script>
  <title>Form</title>
</head>

<body>
  <h2>Update User</h2>
  <main class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
      <section class="auth-block">
        <div class="input-container">
          <label for="name">New Name</label>
          <input type="text" id="name" name="name" />
        </div>
        <div class="input-container">
          <label for="login">Login</label>
          <input type="text" id="login" name="login" />
        </div>
      </section>
      <section class="misc-block">
        <div class="input-container">
          <label for="file">New File</label>
          <input type="file" id="file" name="image" />
        </div>
        <div class="input-container">
          <label for="email">New Email</label>
          <input type="email" id="email" name="email" />
        </div>
        <div class="input-container">
          <label for="country">New Country</label>
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