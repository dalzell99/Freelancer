<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = $_POST['email'];
$sql2 = "SELECT userID, username FROM Users WHERE email = '$email'";

if ($_POST['TxStatus'] == 'SUCCESS' && ($result = mysqli_query($con, $sql2))) {
	$row = mysqli_fetch_assoc($result);
	$userID = $row['userID'];
	$username = $row['username'];
	$amount = intval($_POST['amount']);

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
			error_log("Email: " . $to[0] . ", From: $from, Message: $message");
		}
	} else {
		error_log("SQL: $sql, SQL3: $sql3");
	}
}
?>
