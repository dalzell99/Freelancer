<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sqlUsers = "SELECT * FROM Users";
$sqlQuizzes = "SELECT * FROM Quizzes WHERE paidOut = 'n'";
$startDate = strtotime("1 April 2016");
$now = time();

if (($resultUser = mysqli_query($con, $sqlUsers)) && ($resultQuiz = mysqli_query($con, $sqlQuizzes))) {
    $numRegisteredUsers = mysqli_num_rows($resultUser);
    $numLiveQuizzes = 0;
    $totalPrizePool = 0;
    $daysOnline = ceil(($now - $startDate) / (60 * 60 * 24));

    while ($rowQuiz = mysqli_fetch_assoc($resultQuiz)) {
        $secondsToStart = $now - strtotime($rowQuiz['startTime']);

        if ($secondsToStart < 0) {
            $numLiveQuizzes += 1;
        }

        if ($rowQuiz['type'] == 'paid') {
            $prizes = json_decode($rowQuiz['pointsRewards']);
            foreach ($prizes as $prize) {
                $totalPrizePool += $prize;
            }
        }
    }

    echo json_encode(array($numRegisteredUsers, $daysOnline, $totalPrizePool, $numLiveQuizzes));
} else {
    echo json_encode(array('fail', $sqlUsers . ", " . $sqlQuizzes));
}

mysqli_close($con);
?>
