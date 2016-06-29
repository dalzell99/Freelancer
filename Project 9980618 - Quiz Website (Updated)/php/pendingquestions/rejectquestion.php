<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$questionID = $_POST['questionID'];

$sqlRejectedQuestions = "UPDATE PendingQuestions SET rejected = 'y' WHERE questionID = '$questionID'";
if ($resultRejectedQuestions = mysqli_query($con, $sqlRejectedQuestions)) {
    echo 'success';
} else {
    echo "fail $sqlRejectedQuestions";
}


mysqli_close($con);
?>
