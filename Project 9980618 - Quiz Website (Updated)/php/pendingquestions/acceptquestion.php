<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$questionID = $_POST['questionID'];
$question = mysqli_real_escape_string($con, $_POST['question']);
$answers = mysqli_real_escape_string($con, $_POST['answers']);
$correctAnswer = $_POST['correctAnswer'];
$category = 'Miscellaneous';
$creator = $_POST['creator'];

$sql = "INSERT INTO Questions VALUES (DEFAULT, '$question', '$answers', '$correctAnswer', '$category', '$creator')";
$sqlUser = "UPDATE Users SET approvedQuestionCount = approvedQuestionCount + 1 WHERE username = '$creator'";
if (mysqli_query($con, $sql) && mysqli_query($con, $sqlUser)) {
    echo 'success';

    $sqlDelete = "DELETE FROM PendingQuestions WHERE questionID = $questionID";
    mysqli_query($con, $sqlDelete);
} else {
    echo "fail $sql $sqlUser";
}

mysqli_close($con);
?>
