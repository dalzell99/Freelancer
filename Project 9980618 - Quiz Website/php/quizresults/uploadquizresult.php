<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$quizID = $_POST['quizID'];
$username = $_POST['username'];
$timeTaken = $_POST['timeTaken'];
$questions = mysqli_real_escape_string($con, json_encode($_POST['questions']));
$correctPercent = $_POST['correctPercent'];

$sql = "INSERT INTO QuizResults VALUES ('$userID', '$quizID', '$username', '$timeTaken', '$questions', '$correctPercent')";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>