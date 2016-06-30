<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizID = $_POST['quizID'];
$startTime = $_POST['startTime'];
$endTime = $startTime;
$endTime[15] = '2';

$sql = "UPDATE Quizzes SET startTime = '$startTime', endTime = '$endTime' WHERE quizID = $quizID";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
