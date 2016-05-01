<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$type = $_POST['type'];
$questions = mysqli_real_escape_string($con, $_POST['questions']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$pointsRewards = $_POST['pointsRewards'];
$pointsCost = $_POST['pointsCost'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$rules = mysqli_real_escape_string($con, $_POST['rules']);

$sql = "INSERT INTO Quizzes VALUES (DEFAULT, '$type', '$questions', '$category', '$pointsRewards', $pointsCost, '$startTime', '$endTime', -1, '[]', '$rules', 'n', 'n')";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
