<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$questionID = $_POST['questionID'];
$question = $_POST['question'];
$answers = $_POST['answers'];
$correctAnswer = $_POST['correctAnswer'];
$category = 'Miscellaneous';
$creator = $_POST['creator'];

$sql = "INSERT INTO Questions VALUES (DEFAULT, '$question', '$answers', '$correctAnswer', '$category', '$creator')";
if (mysqli_query($con, $sql)) {
    echo 'success';

    $sqlDelete = "DELETE FROM PendingQuestions WHERE questionID = $questionID";
    mysqli_query($con, $sqlDelete);
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
