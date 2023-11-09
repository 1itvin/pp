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

if (isset($_GET['submit'])) {
  if (!file_exists($file)) {
    echo 'File not found';
    return;
  }

  $login = '';

  if (isset($_GET['login'])) {
    $login = filter_input(INPUT_GET, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
  }

  $handle_read = fopen($file, 'r');
  $contents = fgetcsv($handle_read);
  fclose($handle_read);

  if ($contents === false) {
    echo 'No data';
    return;
  }

  $new_arr = array_chunk($contents, 7);

  if ($login === '') {
    $str_to_alert = "";
    $temp = "";
    echo '<ol style="width: 50vw">';
    foreach ($new_arr as $value) {
      echo '<li><ul>';
      echo "<li style='word-wrap: break-word'>Name: {$value[0]}</li><li style='word-wrap: break-word'>Login: {$value[1]}</li><li style='word-wrap: break-word'>Pass: {$value[2]}</li><li style='word-wrap: break-word'>Email: {$value[3]}</li><li style='word-wrap: break-word'>Country: {$value[4]}</li><li style='word-wrap: break-word'>File: {$value[5]}</li>";
      echo '</li></ul>';
    }
    echo '</ol>';
    return;
  } else {
    foreach ($new_arr as $value) {
      if ($value[1] === $login) {
        echo '<ul>';
        echo "<li>Name: {$value[0]}</li><li>Login: {$value[1]}</li><li>Pass: {$value[2]}</li><li>Email: {$value[3]}</li><li>Country: {$value[4]}</li><li style='word-wrap: break-word'>File: {$value[5]}</li>";
        echo '</ul>';
        return;
      }
    }

    echo '<script>alert("Not found")</script>';
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
  <script src="./get_form.js" defer></script>
  <title>Form</title>
</head>

<body>
  <h2>Get User</h2>
  <main class="container">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" enctype="multipart/form-data">
      <section class="auth-block">
        <div class="input-container">
          <label for="login">Login</label>
          <input type="text" id="login" name="login" />
        </div>
        </div>
      </section>
      <button type="submit" class="submit-btn" id="submit-btn" name="submit">Submit</button>
    </form>
  </main>
</body>

</html>