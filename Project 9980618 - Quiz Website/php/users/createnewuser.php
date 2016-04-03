<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = md5($_POST['password'] . $username);
$email = mysqli_real_escape_string($con, $_POST['email']);
$emailCode = $_POST['emailCode'];
$sql = "INSERT INTO Users VALUES (DEFAULT, '$username', '$password', 0, 0, 50, '$email', '$emailCode', '[]', '', '[]', '', 'y')";

$to = $email;
$from = 'emailverification@ccrscoring.co.nz';
$subject = "Email Verfication";
$message = "
<html>
    <body>
        <p>Dear " . $username . ",<br>Thank you for registering on Quizetos.com! Click the link below to verify your email address:</p>
        <p><a href='http://ccrscoring.co.nz/9980618/emailverification.php?email=" . $email . "&code=" . $emailCode . "'>Click here to verify your email</a></p>
        <p>You can also copy and paste the above link in the address bar of your browser to verify email/activate account.</p>
        <p>Thanks & Regards,<br>Team Quizetos.com</p>
    </body>
</html>
";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= "From: " . $from . "\r\n";

if (mysqli_query($con, $sql)) {
    if (mail($to, $subject, $message, $headers)) {
        echo 'success';
    } else {
        mysqli_query($con, "DELETE FROM Users WHERE username = '$username'");
        echo 'Verication email unable to be sent. Please try signing up again later.';
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>