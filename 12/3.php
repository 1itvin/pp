<?php
include('userinfo.php');

echo "User IP - ". UserInfo::get_ip();
echo "<br>";
echo "User Browser - ". UserInfo::get_browser();
echo "<br>";
echo "User OS - ". UserInfo::get_os();
echo "<br>";
echo "User Device - ". UserInfo::get_device();
?>