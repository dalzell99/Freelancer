<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_POST['quizID'];

$sql = "SELECT * FROM QuizResults WHERE quizID = '$id' ORDER BY correctPercent DESC, timeTaken ASC";
$response = [];

if ($result = mysqli_query($con, $sql)) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    
    echo json_encode(array('success', $response));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>