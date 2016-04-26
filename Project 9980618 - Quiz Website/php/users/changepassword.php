<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = md5(md5($_POST['newPassword'] . strtolower($username)) . $salt);

$sql = "UPDATE Users SET password = '$password' WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>