<?php
require('../database.php');

$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT quizID, endTime FROM Quizzes WHERE (type = 'paid' AND paidOut = 'y') OR type = 'free'";
$now = time();

if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $quizEndTime = strtotime($row['endTime']);
        if ($now - $quizEndTime > 0) { // If the quiz has finished
            mysqli_query($con, "UPDATE Quizzes SET archived = 'y' WHERE quizID = '" . $row['quizID'] . "'");
        }
    }
}

mysqli_close($con);
?>
