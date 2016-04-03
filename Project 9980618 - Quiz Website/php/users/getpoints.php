<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];

$sql = "SELECT freeConvertablePointsBalance, freeUnconvertablePointsBalance, paidPointsBalance FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode(array('success', $row));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>