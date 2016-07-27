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
        $winners = [];
        $tax = [];

        $resultWinners = mysqli_query($con, "SELECT username FROM QuizResults WHERE quizID = " . $row['quizID'] . " AND (userRank = 1 OR  userRank = 2 OR  userRank = 3) ORDER BY userRank DESC");
        while ($rowWinners = mysqli_fetch_assoc($resultWinners)) { $winners[] = $rowWinners; }
        $row['winners'] = $winners;

        $winnersString = '';
        foreach ($winners as $w) {
            $winnersString .= "'" . $w['username'] . "',";
        }
        if (strlen($winnersString) > 0) {
            $winnersString = '(' . substr($winnersString, 0, strlen($winnersString) - 1) . ')';
        } else {
            $winnersString = '()';
        }

        $resultTax = mysqli_query($con, "SELECT taxAmount FROM Taxation WHERE quizID = " . $row['quizID'] . " AND username IN $winnersString ORDER BY taxAmount DESC");
        while ($rowTax = mysqli_fetch_assoc($resultTax)) { $tax[] = $rowTax; }
        $row['tax'] = $tax;

        $response[] = $row;
    }

    echo json_encode(array('success', $response));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>
