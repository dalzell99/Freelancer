<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$creatorUsername = $_POST['username'];
$name = mysqli_real_escape_string($con, $_POST['name'] . ' by ' . $creatorUsername);
$minPlayers = $_POST['minUsers'];
$pointsCost = $_POST['fee'];
$quizMaster = $_POST['quizMaster'];

// Set minimum prize defaults
$sqlDistribution = "SELECT * FROM Distribution";
$resultDistribution = mysqli_query($con, $sqlDistribution);
$percentages = mysqli_fetch_assoc($resultDistribution);
$pointsRewards = json_encode(
    array(
        ($percentages['first'] / 100) * $minPlayers * intval($pointsCost),
        ($percentages['second'] / 100) * $minPlayers * intval($pointsCost),
        ($percentages['third'] / 100) * $minPlayers * intval($pointsCost)
    )
);

$startTime = $_POST['startTime'];
$endTime = $startTime;
$endTime[15] = '2';

$rules = json_encode(["User need real quizeto balance to register in this quiz","Prize pool contains redeemable real quizeto","Winners will be decided based on maximum number of correct answer given in minimum time","User can unregister from the quiz until 10 minutes before the start of the quiz","Incase of less number of participant, quiz will be automatically cancelled","Quizeto will be refunded to respective user account if quiz gets cancelled"]);

$sqlQuizMaster = "SELECT creatorEarnings, quizScheduleTarget, userQuizzesUseAdminQuestions FROM QuizMaster WHERE id = 1";
$resultQuizMaster = mysqli_query($con, $sqlQuizMaster);
$rowQuizMaster = mysqli_fetch_assoc($resultQuizMaster);
$creatorEarnings = $rowQuizMaster['creatorEarnings'];
$quizScheduleTarget = $rowQuizMaster['quizScheduleTarget'];
$userQuizzesUseAdminQuestions = $rowQuizMaster['userQuizzesUseAdminQuestions'];

$sqlQuestion = "SELECT * From Questions WHERE creator <> '$creatorUsername'";
if ($userQuizzesUseAdminQuestions != 'yes') {
    $sqlQuestion .= " AND creator <> 'admin'";
}
$resultQuestion = mysqli_query($con, $sqlQuestion);
$questionArray = [];
while ($row = mysqli_fetch_assoc($resultQuestion)) {
    $questionArray[] = $row;
}

$questions = [];
for ($i = 0; $i < 10; $i += 1) {
    $rand = rand(0, count($questionArray) - 1);
    $questions[] = [
        mysqli_real_escape_string($con, $questionArray[$rand]['question']),
        json_decode($questionArray[$rand]['answers']),
        json_decode($questionArray[$rand]['correctAnswer']),
        $questionArray[$rand]['creator']
    ];

    // Delete question from database
    //mysqli_query($con, "DELETE FROM Questions WHERE questionID = '" . $questionArray[$rand]['questionID'] . "'");

    // Delete question from question array
    array_splice($questionArray, $rand, 1);
}
$questions = str_replace("\\\\", "\\", json_encode($questions));

$sqlQuiz = "INSERT INTO Quizzes (quizID, type, questions, category, pointsRewards, pointsCost, startTime, endTime, rules, minPlayers, creatorUsername, creatorEarnings) VALUES (DEFAULT, 'paid', '$questions', '$name', '$pointsRewards', $pointsCost, '$startTime', '$endTime', '$rules', $minPlayers, '$creatorUsername', '$creatorEarnings')";
if (mysqli_query($con, $sqlQuiz)) {
    $quizID = mysqli_insert_id($con);

    $sqlUser = "UPDATE Users SET approvedQuestionCount = approvedQuestionCount - 10, quizzesScheduledToday = quizzesScheduledToday + 1";
    if ($quizMaster == 'true') {
        $sqlUser .= ", numQuizzesScheduledQuizMaster = numQuizzesScheduledQuizMaster + 1, purchasedQuizzesRemaining = purchasedQuizzesRemaining - 1";
    } else {
        $sqlUser .= ", numQuizzesScheduledUser = numQuizzesScheduledUser + 1, numQuizzesTakenRemaining = numQuizzesTakenRemaining - " . $quizScheduleTarget;
    }
    $sqlUser .= " WHERE username = '$creatorUsername'";

    if (mysqli_query($con, $sqlUser)) {
        echo 'success' . $quizID;
    } else {
        echo 'fail User ' . $sqlUser;
    }
} else {
    echo 'fail Quiz ' . $sqlQuiz;
}

mysqli_close($con);
?>
