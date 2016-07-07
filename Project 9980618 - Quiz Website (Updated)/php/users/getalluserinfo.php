<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_GET['username'];

$sqlQuizResult = "SELECT * FROM QuizResults WHERE username = '$username'";
$sqlConversion = "SELECT * FROM Conversions WHERE username = '$username'";
$sqlPurchase = "SELECT * FROM Purchases WHERE username = '$username'";
$sqlRedeem = "SELECT * FROM Withdrawal WHERE username = '$username'";
$sqlTaxation = "SELECT * FROM Taxation WHERE username = '$username'";
if (($resultQuizResult = mysqli_query($con, $sqlQuizResult)) && ($resultConversion = mysqli_query($con, $sqlConversion)) && ($resultPurchase = mysqli_query($con, $sqlPurchase)) && ($resultRedeem = mysqli_query($con, $sqlRedeem)) && ($resultTaxation = mysqli_query($con, $sqlTaxation))) {
    $response = [];

    $temp = [];
    while ($rowQuizResult = mysqli_fetch_assoc($resultQuizResult)) {
        $sqlQuiz = "SELECT category, startTime, type, pointsCost FROM Quizzes WHERE quizID = " . $rowQuizResult['quizID'];
        $resultQuiz = mysqli_query($con, $sqlQuiz);
        $rowQuiz = mysqli_fetch_assoc($resultQuiz);
        $rowQuizResult['name'] = $rowQuiz['category'];
        $rowQuizResult['date'] = $rowQuiz['startTime'];
        $rowQuizResult['type'] = $rowQuiz['type'];
        $rowQuizResult['registrationFee'] = $rowQuiz['pointsCost'];
        $temp[] = $rowQuizResult;
    }
    $response[] = $temp;

    $temp = [];
    while ($rowConversion = mysqli_fetch_assoc($resultConversion)) {
        $temp[] = $rowConversion;
    }
    $response[] = $temp;

    $temp = [];
    while ($rowPurchase = mysqli_fetch_assoc($resultPurchase)) {
        $temp[] = $rowPurchase;
    }
    $response[] = $temp;

    $temp = [];
    while ($rowRedeem = mysqli_fetch_assoc($resultRedeem)) {
        $temp[] = $rowRedeem;
    }
    $response[] = $temp;

    $temp = [];
    while ($rowTaxation = mysqli_fetch_assoc($resultTaxation)) {
        $sqlQuiz = "SELECT category, startTime, pointsCost FROM Quizzes WHERE quizID = " . $rowTaxation['quizID'];
        $resultQuiz = mysqli_query($con, $sqlQuiz);
        $rowQuiz = mysqli_fetch_assoc($resultQuiz);
        $rowTaxation['name'] = $rowQuiz['category'];
        $rowTaxation['date'] = $rowQuiz['startTime'];
        $rowTaxation['registrationFee'] = $rowQuiz['pointsCost'];
        $temp[] = $rowTaxation;
    }
    $response[] = $temp;

    echo json_encode($response);
} else {
    echo 'fail';
}

mysqli_close($con);
?>
