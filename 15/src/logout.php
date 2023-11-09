<?php
$login_loc = '/src/login.php';

session_start();
session_destroy();

header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . $login_loc);
