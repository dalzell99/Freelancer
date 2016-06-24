<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$type = $_POST['type'];
$questions = mysqli_real_escape_string($con, $_POST['questions']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$pointsCost = $_POST['pointsCost'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$rules = mysqli_real_escape_string($con, $_POST['rules']);
$minPlayers = $_POST['minPlayers'];

$sqlDistribution = "SELECT * FROM Distribution";
$resultDistribution = mysqli_query($con, $sqlDistribution);
$percentages = mysqli_fetch_assoc($resultDistribution);

// Set minimum prize defaults
$pointsRewards = json_encode(
    array(
        ($percentages['first'] / 100) * $minPlayers * intval($pointsCost),
        ($percentages['second'] / 100) * $minPlayers * intval($pointsCost),
        ($percentages['third'] / 100) * $minPlayers * intval($pointsCost)
    )
);

$sql = "INSERT INTO Quizzes (creatorUsername, type, questions, category, pointsRewards, pointsCost, startTime, endTime, rules, minPlayers) VALUES ('$username', '$type', '$questions', '$category', '$pointsRewards', $pointsCost, '$startTime', '$endTime', '$rules', $minPlayers)";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
