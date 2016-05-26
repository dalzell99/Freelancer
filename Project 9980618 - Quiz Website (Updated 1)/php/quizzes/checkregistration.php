<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizID = $_POST['quizID'];
$userID = $_POST['userID'];

$sql = "SELECT type, userRegistered, cancelled FROM Quizzes WHERE quizID = '$quizID'";
if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['type'] == 'paid') {
        if ($row['cancelled'] == 'y') {
            echo 'cancelled';
        } else if (in_array($userID, json_decode($row['userRegistered']))) {
            $sql2 = "SELECT timeTaken FROM QuizResults WHERE quizID = '$quizID' AND userID = '$userID'";
            if ($result2 = mysqli_query($con, $sql2)) {
                $row2 = mysqli_fetch_assoc($result2);
                if (mysqli_num_rows($result2) > 0) {
                    echo 'alreadydone';
                } else {
                    echo 'registered';
                }
            }
        } else {
            echo 'notregistered';
        }
    } else {
        $userRegistered = false;
        $userRegisteredArray = json_decode($row['userRegistered']);

        for ($i = 0; $i < count($userRegisteredArray); $i += 1) {
            if ($userRegisteredArray[$i][0] == $userID) {
                $userRegistered = true;
            }
        }

        if ($userRegistered == true) {
            $sql2 = "SELECT timeTaken FROM QuizResults WHERE quizID = '$quizID' AND userID = '$userID'";
            if ($result2 = mysqli_query($con, $sql2)) {
                $row2 = mysqli_fetch_assoc($result2);
                if (mysqli_num_rows($result2) > 0) {
                    echo 'alreadydone';
                } else {
                    echo 'registered';
                }
            }
        } else {
            echo 'notregistered';
        }
    }
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>
