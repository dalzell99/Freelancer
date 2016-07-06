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

$sql = "INSERT INTO QuizResults VALUES ('$userID', '$quizID', '$username', '$timeTaken', '$questions', '$correctPercent', '')";
$sqlUser = "UPDATE Users SET numQuizzesTaken = numQuizzesTaken + 1, 	numQuizzesTakenRemaining = 	numQuizzesTakenRemaining + 1 WHERE username = '$username'";

if (mysqli_query($con, $sql) && mysqli_query($con, $sqlUser)) {
    echo 'success';
} else {
    echo 'fail ------- ' . $sql . " ------- " . $sqlUser;
}

mysqli_close($con);
?>
