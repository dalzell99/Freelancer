<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$questions = json_decode($_POST['questions']);
$response = 'success';

// Add each question to pendingQuestions table
foreach ($questions as $question) {
    $q = mysqli_real_escape_string($con, $question);
    if (!mysqli_query($con, "INSERT INTO PendingQuestions VALUES (DEFAULT, '$username', '$q', 'n')")) {
        $response = "fail INSERT INTO PendingQuestions VALUES (DEFAULT, '$username', '$q', 'n')";
    }
}

echo $response;

mysqli_close($con);
?>
