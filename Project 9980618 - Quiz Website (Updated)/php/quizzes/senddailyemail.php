<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sqlQuiz = "SELECT * FROM Quizzes";
$sqlUser = "SELECT * FROM Users";
$now = time();
$quizArray = [];
$userEmailArray = [];

// Get all paid quizzes
if ($resultQuiz = mysqli_query($con, $sqlQuiz)) {

    while ($rowQuiz = mysqli_fetch_assoc($resultQuiz)) {
        $quizStartTime = strtotime($rowQuiz['startTime']);
        if ($quizStartTime - $now < 3600 * 24 && $quizStartTime - $now > 0) { // If the quiz starts in the next 24 hours then add to quiz to $quizArray
            $quizArray[] = $rowQuiz;
        }
    }
} else {
    echo 'fail1. ' . $sqlQuiz;
}


if ($resultUser = mysqli_query($con, $sqlUser)) {

    while ($rowUser = mysqli_fetch_assoc($resultUser)) {
        $userEmailArray[] = $rowUser['email'];
    }
} else {
    echo 'fail2. ' . $sqlUser;
}

$message = '';
$message .= "
<html>
    <body>
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Prize Pool</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>";
foreach ($quizArray as $quiz) {
    if ($quiz['type'] == 'paid') {
        $prizePool = 0;
        foreach (json_decode($quiz['pointsRewards']) as $prize) { $prizePool += $prize; }
    } else {
        $prizePool = '5 Bonus Quizeto for 100%, 3 Bonus Quizeto for 94%-99% and 1 Bonus Quizeto for 90%-94%';
    }

    $startTime1 = new DateTime($quiz['startTime']);
    $startTime2 = $startTime1->setTimeZone(new DateTimeZone('Asia/Kolkata'));
    $startTime = $startTime2->format('D jS M g:ia T');
    $endTime1 = new DateTime($quiz['endTime']);
    $endTime2 = $endTime1->setTimeZone(new DateTimeZone('Asia/Kolkata'));
    $endTime = $endTime2->format('D jS M g:ia T');

    $message .= "
            <tr>
                <td>" . $quiz['category'] . "</td>
                <td>" . ucfirst($quiz['type']) . "</td>
                <td>" . $prizePool . "</td>
                <td>" . $startTime . "</td>
                <td>" . $endTime . "</td>
            </tr>
    ";
}
$message.= "
    </body>
</html>
";

$from = $databasephpNoReplyEmail;
if (count($quizArray) > 0) {
    $sendEmailResult = sendEmail($userEmailArray, $from, $subject, $message);
    if ($sendEmailResult != 'success') {
        echo 'mailfail';
    }
}

mysqli_close($con);
?>
