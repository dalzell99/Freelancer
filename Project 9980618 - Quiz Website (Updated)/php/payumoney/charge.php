<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = $_POST['email'];
$userID = $_POST['userID'];
$username = $_POST['username'];
$amount = $_POST['amount'];

$sql = "UPDATE Users SET paidPointsBalance = paidPointsBalance + $amount WHERE userID = '$userID'";
$sql3 = "INSERT INTO Purchases VALUES (default, '$userID', '$username', '$amount', '" . date('c') . "')";

if (mysqli_query($con, $sql) && mysqli_query($con, $sql3)) {
	$to = array($email);
	$from = $databasephpNoReplyEmail;
	$subject = "Real Quizeto Purchase Completed";
	$message = "
	<html>
		<body>
			<p>
				Dear $username,<br>
				Thank you for your purchase on IQzeto.com! $amount Real Quizetos have been added to your account and are ready to be used.
			</p>
			<p>
				Thanks & Regards,<br>
				Team IQzeto.com
			</p>
		</body>
	</html>
	";

	if (sendEmail($to, $from, $subject, $message) != 'success') {
		error_log("Email: " . print_r($to) . ", From: $from, Message: $message", 1, "dalzell99@hotmail.com");
		error_log("Email: " . print_r($to) . ", From: $from, Message: $message");
	}

	echo "success";
} else {
	echo "fail $sql $sql3";
}
?>
