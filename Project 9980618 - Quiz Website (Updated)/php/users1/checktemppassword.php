<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT password FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['password'] == $password) {
        echo 'correct';
    } else {
        echo 'incorrect';
    }
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>