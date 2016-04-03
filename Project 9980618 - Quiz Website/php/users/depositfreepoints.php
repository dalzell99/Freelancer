<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$numCorrect = $_POST['numCorrect'];
$correctPercent = $_POST['correctPercent'];

if ($correctPercent == '100') {
    $numCorrect += 5;
} else if ($correctPercent >= '90') {
    $numCorrect += 4;
} else if ($correctPercent >= '80') {
    $numCorrect += 3;
}

$sql = "UPDATE Users SET freeConvertablePointsBalance = freeConvertablePointsBalance + '$numCorrect' WHERE userID = '$userID'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>