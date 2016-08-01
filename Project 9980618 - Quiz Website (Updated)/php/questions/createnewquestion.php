<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$question = mysqli_real_escape_string($con, $_POST['question']);
$answers = mysqli_real_escape_string($con, $_POST['answers']);
$correctAnswer = $_POST['correctAnswer'] - 1;
$category = mysqli_real_escape_string($con, $_POST['category']);

$sql = "INSERT INTO Questions VALUES (DEFAULT, '$question', '$answers', '$correctAnswer', '$category', 'admin')";
$sqlCat = "INSERT INTO QuestionCategory VALUES (DEFAULT, '$category')";
if (mysqli_query($con, $sql)) {
    mysqli_query($con, $sqlCat);
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
