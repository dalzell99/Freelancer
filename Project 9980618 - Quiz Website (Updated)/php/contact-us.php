<?php
require('database.php');
require('sendemail.php');

$toEmail = array($_POST['toEmail']);
$subject = $_POST['subject'];

$message = "
$username: " . $_POST['username'] . "<br />
$userEmail: " . $_POST['userEmail'] . "<br />
$firstName: " . $_POST['firstName'] . "<br />
$lastName: " . $_POST['lastName'] . "<br />
$phone: " . $_POST['phone'] . "<br />
$address: " . $_POST['address'] . "<br />
$message: " . $_POST['message'] . "<br />
";

echo sendEmail($toEmail, $databasephpNoReplyEmail, $subject, $message);
?>
