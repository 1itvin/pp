<?php
header('Content-Type: application/json; charset=UTF-8');
$messages_file = $_SERVER['DOCUMENT_ROOT'] . '/db/messages.csv';

// if (!file_exists($messages_file)) {
//   echo json_encode([]);
//   return;
// }

$data = json_decode(file_get_contents("php://input"));
// echo file_get_contents("php://input");
// echo $data->name;
if (
  empty($data->id) ||
  empty($data->date) ||
  empty($data->login) ||
  empty($data->name) ||
  empty($data->title)
) {
  echo $data->date;
  return;
}

if (!file_exists($messages_file)) {
  $handle = fopen($messages_file, 'w');
  fclose($handle);
}

$handle_read = fopen($messages_file, 'r');
$contents = fgetcsv($handle_read);
fclose($handle_read);
// 1,user,Artem,Fuck you,05-19-2022
if ($contents === false) {
  $handle_write = fopen($messages_file, 'w');
  fputcsv($handle_write, [$data->id, $data->login, $data->name, $data->title, $data->date]);
  fclose($handle_write);

  // echo '<script>alert("Posted successfully")</script>';

  // session_start();
  // $_SESSION['login'] = $login;
  // setcookie('login', $login);
  // setcookie('name', $name);
  // // $_SESSION['role'] = 'user';
  // header('Location: ' . $user_dashboard_location);
  return;
}

$new_arr = array_chunk($contents, 5);

// $is_entry_found = false;

// foreach ($new_arr as $key => $value) {
//   if ($value[0] === $login) {
//     echo "<script>alert('User already exists')</script>";
//     $is_entry_found = true;
//   }
// }

// if (!$is_entry_found) {
array_push($new_arr, [$data->id, $data->login, $data->name, $data->title, $data->date]);

$new_new_arr = array_merge(...$new_arr);

$handle_write = fopen($messages_file, 'w');
fputcsv($handle_write, $new_new_arr);
fclose($handle_write);

return;

// echo '<script>alert("Posted successfully")</script>';

// session_start();
// $_SESSION['login'] = $login;
// setcookie('login', $login);
// setcookie('name', $name);
// header('Location: ' . $user_dashboard_location);
// }
// $handle_read = fopen($messages_file, 'r');
// $contents = fgetcsv($handle_read);
// fclose($handle_read);

// if ($contents === false) {
//   echo json_encode([]);
//   return;
// }

// $new_arr = array_chunk($contents, 5);

// function getEntry($el)
// {
//   $entry = [
//     "id" => $el[0],
//     "login" => $el[1],
//     "name" => $el[2],
//     "title" => $el[3],
//     "date" => $el[4],
//   ];
//   return $entry;
// }

// $new_new_arr = array_map('getEntry', $new_arr);

// echo json_encode($new_new_arr);
