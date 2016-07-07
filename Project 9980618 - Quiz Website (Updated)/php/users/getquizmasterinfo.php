<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT username, email, mobile, pancard, purchasedQuizzesRemaining, approvedQuestionCount,  numQuizzesTakenRemaining, numQuizzesPurchased, numQuizzesScheduledQuizMaster, numQuizzesScheduledUser, numQuizzesTaken, lockStart FROM Users";
$sql2 = "SELECT * FROM QuizMaster WHERE id = 1";
$response = [];

if (($result = mysqli_query($con, $sql)) && ($result2 = mysqli_query($con, $sql2))) {

    while ($row = mysqli_fetch_assoc($result)) {
        $sqlRejected = "SELECT * FROM PendingQuestions WHERE rejected = 'y' AND username = '" . $row['username'] . "'";
        $resultRejected = mysqli_query($con, $sqlRejected);
        $rejectedQuestions = [];
        while ($rowRejected = mysqli_fetch_assoc($resultRejected)) {
            $rejectedQuestions[] = $rowRejected;
        }
        $row['rejectedQuestions'] = $rejectedQuestions;
        $response[] = $row;
    }

    echo json_encode(array('success', $response, mysqli_fetch_assoc($result2)));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>
