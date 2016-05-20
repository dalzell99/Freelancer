<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);

$sql = "SELECT userID FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo 'exists';
    } else {
        echo 'notexists';
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>