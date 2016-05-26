<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "UPDATE Users SET loggedInToday = 'n'";


if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>