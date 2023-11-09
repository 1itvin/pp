<?php
header('Content-Type: application/json; charset=UTF-8');
$messages_file = $_SERVER['DOCUMENT_ROOT'] . '/db/messages.csv';

if (!file_exists($messages_file)) {
  echo json_encode([]);
  return;
}

$handle_read = fopen($messages_file, 'r');
$contents = fgetcsv($handle_read);
fclose($handle_read);

if ($contents === false) {
  echo json_encode([]);
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

echo json_encode($new_new_arr);
