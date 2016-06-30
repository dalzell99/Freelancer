<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$quizScheduleTarget = $_POST['quizScheduleTarget'];
$creatorEarnings = $_POST['creatorEarnings'];
$costPerPurchase = $_POST['costPerPurchase'];
$numQuizzesPerPurchase = $_POST['numQuizzesPerPurchase'];
$userQuizzesUseAdminQuestions = $_POST['userQuizzesUseAdminQuestions'];
$schedulingTimes = $_POST['schedulingTimes'];

$sql = "UPDATE QuizMaster SET quizScheduleTarget = $quizScheduleTarget, creatorEarnings = $creatorEarnings, costPerPurchase = $costPerPurchase, numQuizzesPerPurchase = $numQuizzesPerPurchase, userQuizzesUseAdminQuestions = '$userQuizzesUseAdminQuestions', schedulingTimes = '$schedulingTimes' WHERE id = 1";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
