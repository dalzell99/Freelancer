<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$paidPoints = $_POST['paidPoints'];
$freeConvertablePoints = $_POST['freeConvertablePoints'];
$freeUnconvertablePoints = $_POST['freeUnconvertablePoints'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

$sql = "UPDATE Users SET paidPointsBalance = '$paidPoints', freeConvertablePointsBalance = '$freeConvertablePoints', freeUnconvertablePointsBalance = '$freeUnconvertablePoints', email = '$email', mobile = '$mobile' WHERE userID = '$userID'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>
