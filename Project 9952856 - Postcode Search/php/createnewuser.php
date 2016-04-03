<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$type = $_POST['type'];
$name = mysqli_real_escape_string($con, $_POST['name']);
$basecamp = mysqli_real_escape_string($con, $_POST['basecamp']);
$postcode1 = $_POST['postcode1'];
$url = mysqli_real_escape_string($con, $_POST['url']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$available = ($type == 'delivery' ? 'n' : '');
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO Users (username, password, name, basecamp, postcode1, url, email, type, available) 
        VALUES ('$username', '$password', '$name', '$basecamp', '$postcode1', '$url', '$email', '$type', '$available')";

if ($result = mysqli_query($con, $sql)) {
    $response = 'success';
} else {
    $response = 'fail';
}

echo $response;

mysqli_close($con);
?>