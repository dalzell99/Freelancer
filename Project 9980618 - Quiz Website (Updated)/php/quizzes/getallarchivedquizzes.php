<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT quizID, type, questions, category, pointsRewards, pointsCost, startTime, endTime, rules, userRegistered, minPlayers, creatorUsername, cancelled FROM Quizzes WHERE archived = 'y'";
$response = [];

if ($result = mysqli_query($con, $sql)) {

    while ($row = mysqli_fetch_assoc($result)) {
        $row['winners'] = ['dalzell99', 'dalzell98', 'cfd19'];
        $row['tax'] = [10000, 5000, 0];
        $response[] = $row;
    }

    echo json_encode(array('success', $response));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>
