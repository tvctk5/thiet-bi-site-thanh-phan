<?php
$server_username = "cantv";
$server_password = "123**abc";
$server_host = "localhost";
$database = 'trantu';

$conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("không thể kết nối tới database");
mysqli_query($conn,"SET NAMES 'UTF8'");