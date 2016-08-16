<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = $_POST['email'];
$sql3 = "SELECT userID, username FROM Users WHERE email = '$email'";
$sql4 = "SELECT numQuizzesPerPurchase FROM QuizMaster WHERE id = 1";

if ($_POST['TxStatus'] == 'SUCCESS' && ($result = mysqli_query($con, $sql3)) && ($resultQuizMaster = mysqli_query($con, $sql4))) {
	$row = mysqli_fetch_assoc($result);
	$userID = $row['userID'];
	$username = $row['username'];

	$numQuizzes = mysqli_fetch_assoc($resultQuizMaster)['numQuizzesPerPurchase'];

	$sql = "UPDATE Users SET purchasedQuizzesRemaining = purchasedQuizzesRemaining + $numQuizzes, numQuizzesPurchased = numQuizzesPurchased + $numQuizzes WHERE userID = '$userID'";
	if (mysqli_query($con, $sql)) {
		$to = array($email);
		$from = $databasephpQuizMasterEmail;
		$subject = "Paid Quiz Purchase Completed";
		$message = "
		<html>
			<body>
				<p>Dear $username,</p>
				<p>You have successfully unlocked scheduling of $numQuizzes paid quizzes. Please login to your account and check the details under My Account--Quiz Master--Activate as Quiz master tabFor any concern please feel free to write us to quizmaster@iqzeto.com,</p>

				<p>We will be happy to assist</p>

				<p>Happy Quizzing</p>
				<p>RegardsTeam IQzeto</p>
			</body>
		</html>
		";

		sendEmail($to, $from, $subject, $message);
		echo 'success';
	} else {
		echo json_encode(['sqlfail', $sql]);
	}
} else {
	echo json_encode(['sqlfail', $sql3 . $sql4]);
}
?>
