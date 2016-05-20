<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizID = $_GET['quizID'];

$sql = "SELECT * FROM Quizzes WHERE quizID = '$quizID'";
if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['checked'] == 'y') {
        if ($row['cancelled'] == 'y') {
            echo json_encode('cancelled');
        } else {
            echo json_encode(array('success', $row['pointsRewards']));
        }
    } else {
        echo json_encode('notchecked');
    }
} else {
    echo json_encode('fail');
}

mysqli_close($con);
?>
