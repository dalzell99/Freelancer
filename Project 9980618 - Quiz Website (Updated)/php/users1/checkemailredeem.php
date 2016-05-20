<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$email = mysqli_real_escape_string($con, $_POST['email']);

$sql = "SELECT userID FROM Users WHERE email = '$email' AND userID = '$userID'";

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