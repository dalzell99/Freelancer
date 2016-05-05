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
$pointsCost = $_POST['pointsCost'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$rules = mysqli_real_escape_string($con, $_POST['rules']);

$sqlDistribution = "SELECT * FROM Distribution";
$resultDistribution = mysqli_query($con, $sqlDistribution);
$percentages = mysqli_fetch_assoc($resultDistribution);

// $minRegisteredUsers is in database.php
$pointsRewards = json_encode(
    array(
        ($percentages['first'] / 100) * $minRegisteredUsers * intval($pointsCost),
        ($percentages['second'] / 100) * $minRegisteredUsers * intval($pointsCost),
        ($percentages['third'] / 100) * $minRegisteredUsers * intval($pointsCost)
    )
);

$sql = "INSERT INTO Quizzes VALUES (DEFAULT, '$type', '$questions', '$category', '$pointsRewards', $pointsCost, '$startTime', '$endTime', -1, '[]', '$rules', 'n', 'n', 'n')";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
