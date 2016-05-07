<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizID = $_POST['quizID'];
$type = $_POST['type'];
$questions = mysqli_real_escape_string($con, $_POST['questions']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$pointsCost = $_POST['pointsCost'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$rules = mysqli_real_escape_string($con, $_POST['rules']);
$minPlayers = $_POST['minPlayers'];

$sql = "UPDATE Quizzes SET type = '$type', questions = '$questions', category = '$category',  pointsCost = $pointsCost, startTime = '$startTime', endTime = '$endTime', rules = '$rules', minPlayers = $minPlayers WHERE quizID = $quizID";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
