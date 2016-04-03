<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$time = date("Y-m-d H:i:s");

// Update game element with new values
$update = "UPDATE Users SET lastTimeLoggedIn = '$time' WHERE username = '$username'";

if (mysqli_query($con, $update)) {
    echo 'success';
} else {
    echo 'fail' . $update;
}

mysqli_close($con);
?>