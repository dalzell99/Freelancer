<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizID = $_POST['quizID'];
$column = $_POST['column'];
$value = $_POST['value'];

$sql = "UPDATE Quizzes SET $column = '$value' WHERE quizID = $quizID";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
