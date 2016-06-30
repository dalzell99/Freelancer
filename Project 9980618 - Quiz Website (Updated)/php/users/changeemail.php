<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$emailCode = mysqli_real_escape_string($con, $_POST['emailCode']);

$sql = "UPDATE Users SET email = '$email', emailConfirmed = '$emailCode' WHERE username = '$username'";

$to = array($email);
$from = $databasephpNoReplyEmail;
$subject = "Email Verfication";
$message = "
<html>
    <body>
        <p>Dear " . $username . ",<br>Thank you for registering on IQzeto.com! Click the link below to verify your email address:</p>
        <p><a href='https://www.iqzeto.com/emailverification.php?email=" . $email . "&code=" . $emailCode . "'>Click here to verify your email</a></p>
        <p>You can also copy and paste the above link in the address bar of your browser to verify email/activate account.</p>

        <p>Thanks & Regards,<br>Team IQzeto.com</p>
    </body>
</html>
";

if (mysqli_query($con, $sql)) {
    $sendEmailResult = sendEmail($to, $from, $subject, $message);
    if ($sendEmailResult == 'success') {
        echo 'success';
    } else {
        echo 'Verification email couldn\'t be sent.';
    }
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>
