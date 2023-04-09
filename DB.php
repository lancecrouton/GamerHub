<?php

$host = 'localhost';
$username = 'gamerhubdatabase';
$password = 'gamerhubdatabase';
$dbname = 'gamerhubdatabase';

$conn = mysqli_connect($host, $username, $password, $dbname);

if(mysqli_connect_error()) {
echo "DB Connection error: " . mysqli_error($conn);
exit();
}
?>