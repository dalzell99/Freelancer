<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$questionID = $_POST['questionID'];
$username = $_POST['username'];

$sqlRejectedQuestions = "UPDATE PendingQuestions SET rejected = 'y' WHERE questionID = '$questionID'";
$sqlUser = "SELECT email FROM Users WHERE username = '$username'";
if (mysqli_query($con, $sqlRejectedQuestions) && ($result = mysqli_query($con, $sqlUser))) {
    echo 'success';
    sendEmail([mysqli_fetch_assoc($result)['email']], $databasephpQuizMasterEmail, "Question Rejected", "
    <p>
        Dear " . $username . "
    </p>
    <p>
        One of your submitted questions did not pass our screening criteria. Please try submitting different question.
    </p>
    <p>
        Regards
    </p>
    <p>
        IQzeto Quizmaster
    </p>
    ");
} else {
    echo "fail $sqlRejectedQuestions";
}


mysqli_close($con);
?>
