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
$category = mysqli_real_escape_string($con, $_POST['category']);

$sql = "UPDATE Questions SET question = '$question', answers = '$answers', correctAnswer = '$correctAnswer', category = '$category' WHERE questionID = '$questionID'";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
