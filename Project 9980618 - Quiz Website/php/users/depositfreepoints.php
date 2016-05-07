<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$numCorrect = 0;
$correctPercent = $_POST['correctPercent'];

if ($correctPercent == '100') {
    $numCorrect += 5;
} else if ($correctPercent >= '95') {
    $numCorrect += 3;
} else if ($correctPercent >= '90') {
    $numCorrect += 1;
}

$sql = "UPDATE Users SET freeConvertablePointsBalance = freeConvertablePointsBalance + '$numCorrect' WHERE userID = '$userID'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>
