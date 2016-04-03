<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);
date_default_timezone_set('UTC');

$sender = mysqli_real_escape_string($con, $_POST['sender']);
$receiver = mysqli_real_escape_string($con, $_POST['receiver']);
$message = mysqli_real_escape_string($con, $_POST['message']);
$timeSent = date("Y-m-d H:i:s");
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO Messages (sender, receiver, message, timeSent) VALUES ('$sender', '$receiver', '$message', '$timeSent')";

if ($result = mysqli_query($con, $sql)) {
    $response = 'success';
} else {
    $response = 'fail'. $sql;
}

echo $response;

mysqli_close($con);
?>