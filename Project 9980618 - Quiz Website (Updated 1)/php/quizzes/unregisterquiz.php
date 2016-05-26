<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$quizID = $_POST['quizID'];

$sqlQuiz = "SELECT pointsCost, userRegistered, type FROM Quizzes WHERE quizID = '$quizID'";
if ($resultQuiz = mysqli_query($con, $sqlQuiz)) {
    $rowQuiz = mysqli_fetch_assoc($resultQuiz);
    $userArray = json_decode($rowQuiz['userRegistered']);

    if ($rowQuiz['type'] == 'free') {
        $index = -1;
        for ($i = 0; $i < count($userArray) && $index == -1; $i += 1) {
            if ($userArray[$i][0] == $userID) {
                $sqlBalanceChangeConvertable = "UPDATE Users SET freeConvertablePointsBalance = freeConvertablePointsBalance + " . $userArray[$i][1] . " WHERE userID = '$userID'";
                $sqlBalanceChangeUnconvertable = "UPDATE Users SET freeUnconvertablePointsBalance = freeUnconvertablePointsBalance + " . $userArray[$i][2] . " WHERE userID = '$userID'";
                $index = $i;
            }
        }

        // Remove userID from array of users registered for this quiz
        array_splice($userArray, $index, 1);
        $userArrayUpdated = json_encode($userArray);
        $sqlAddUserToQuiz = "UPDATE Quizzes SET userRegistered = '$userArrayUpdated' WHERE quizID = '$quizID'";

        if (mysqli_query($con, $sqlBalanceChangeConvertable) && mysqli_query($con, $sqlBalanceChangeUnconvertable) && mysqli_query($con, $sqlAddUserToQuiz)) {
            echo json_encode(array('success', ''));
        } else {
            echo json_encode(array('fail', $sqlBalanceChange . ', ' . $sqlAddUserToQuiz));
        }
    } else {
        $sqlBalanceChange = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $rowQuiz['pointsCost'] . " WHERE userID = '$userID'";

        $index = -1;
        for ($i = 0; $i < count($userArray) && $index == -1; $i += 1) {
            if ($userArray[$i] == $userID) {
                $index = $i;
            }
        }

        // Remove userID from array of users registered for this quiz
        array_splice($userArray, $index, 1);
        $userArrayUpdated = json_encode($userArray);
        $sqlAddUserToQuiz = "UPDATE Quizzes SET userRegistered = '$userArrayUpdated' WHERE quizID = '$quizID'";

        if (mysqli_query($con, $sqlBalanceChange) && mysqli_query($con, $sqlAddUserToQuiz)) {
            echo json_encode(array('success', ''));
        } else {
            echo json_encode(array('fail', $sqlBalanceChange . ', ' . $sqlAddUserToQuiz));
        }
    }

} else {
    echo json_encode(array('fail', $sqlUser . ', ' . $sqlQuiz));
}

mysqli_close($con);
?>
