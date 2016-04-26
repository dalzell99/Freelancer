<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$password = mysqli_real_escape_string($con, $_POST['password']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$sql = "SELECT * FROM Admin";

if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['password'] == $password && $row['username'] == $username) {
            echo 'correct';
        } else {
            echo 'incorrect';
        }
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>