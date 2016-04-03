<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = $_POST['username'];
$available = $_POST['available'];
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "UPDATE Users SET available = '$available' WHERE username = '$username'")) {
    $response = 'success';
} else {
    $response = 'fail';
}

echo $response;

mysqli_close($con);
?>