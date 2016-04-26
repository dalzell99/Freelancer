<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$password = hashPassword($con, $_POST['password']);

if ($result = mysqli_query($con, "UPDATE Customer SET password = '$password' WHERE username = '$username'")) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
