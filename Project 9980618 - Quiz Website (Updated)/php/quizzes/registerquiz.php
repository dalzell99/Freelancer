<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$quizID = $_POST['quizID'];
$balance = $_POST['balance'];

$sqlUser = "SELECT freeConvertablePointsBalance, freeUnconvertablePointsBalance, paidPointsBalance FROM Users WHERE userID = '$userID'";
$sqlQuiz = "SELECT pointsCost, userRegistered, type FROM Quizzes WHERE quizID = '$quizID'";
if (($resultUser = mysqli_query($con, $sqlUser)) && ($resultQuiz = mysqli_query($con, $sqlQuiz))) {
    $rowUser = mysqli_fetch_assoc($resultUser);
    $rowQuiz = mysqli_fetch_assoc($resultQuiz);
    
    if (($rowQuiz['type'] == 'free' && $rowQuiz['pointsCost'] <= $rowUser['freeConvertablePointsBalance'] && $balance == 'convertable') ||
        ($rowQuiz['type'] == 'free' && $rowQuiz['pointsCost'] <= $rowUser['freeUnconvertablePointsBalance'] && $balance == 'unconvertable') ||
        ($rowQuiz['type'] == 'paid' && $rowQuiz['pointsCost'] <= $rowUser['paidPointsBalance'])) {
        if ($rowQuiz['type'] == 'free' && $balance == 'convertable') {
            $sqlBalanceChange = "UPDATE Users SET freeConvertablePointsBalance = " . ($rowUser['freeConvertablePointsBalance'] - $rowQuiz['pointsCost']) . " WHERE userID = '$userID'";
        } else if ($rowQuiz['type'] == 'free' && $balance == 'unconvertable') {
            $sqlBalanceChange = "UPDATE Users SET freeUnconvertablePointsBalance = " . ($rowUser['freeUnconvertablePointsBalance'] - $rowQuiz['pointsCost']) . " WHERE userID = '$userID'";
        } else {
            $sqlBalanceChange = "UPDATE Users SET paidPointsBalance = " . ($rowUser['paidPointsBalance'] - $rowQuiz['pointsCost']) . " WHERE userID = '$userID'";
        }
        
        // Add userID to array of users registered for this quiz
        $sqlGetUsersListForQuiz = "SELECT userRegistered FROM Quizzes WHERE quizID = '$quizID'";
        $quizResult = mysqli_query($con, $sqlGetUsersListForQuiz);
        $quizAssoc = mysqli_fetch_assoc($quizResult);
        $userArray = json_decode($quizAssoc['userRegistered']);
        if ($rowQuiz['type'] == 'free' && $balance == 'convertable') {
            array_push($userArray, array($userID, $rowQuiz['pointsCost'], 0));
        } else if ($rowQuiz['type'] == 'free' && $balance == 'unconvertable') {
            array_push($userArray, array($userID, 0, $rowQuiz['pointsCost']));
        } else {
            array_push($userArray, $userID);
        }
        $userArrayUpdated = json_encode($userArray);
        $sqlAddUserToQuiz = "UPDATE Quizzes SET userRegistered = '$userArrayUpdated' WHERE quizID = '$quizID'";
        
        if (mysqli_query($con, $sqlBalanceChange) && mysqli_query($con, $sqlAddUserToQuiz)) {
            echo json_encode(array('success', ''));
        } else {
            echo json_encode(array('fail', $sqlBalanceChange . ', ' . $sqlAddUserToQuiz));
        }
    } else {
        echo json_encode(array('notenoughpoints', ''));
    }
} else {
    echo json_encode(array('fail', $sqlUser . ', ' . $sqlQuiz));
}

mysqli_close($con);
?>