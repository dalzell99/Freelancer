<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$emailCode = mysqli_real_escape_string($con, $_POST['emailCode']);

$sql = "UPDATE Users SET email = '$email', emailConfirmed = '$emailCode' WHERE username = '$username'";

$to = $email;
$from = 'emailverification@ccrscoring.co.nz';
$subject = "Email Verfication";
$message = "
<html>
    <body>
        <p>Dear " . $username . ",<br>Thank you for registering on Adda52.com! Click the link below to verify your email address:</p>
        <p><a href='http://ccrscoring.co.nz/9980618/emailverification.php?email=" . $email . "&code=" . $emailCode . "'>Click here to verify your email</a></p>
        <p>You can also copy and paste the above link in the address bar of your browser to verify email/activate account.</p>
        <p>Join the daily freeroll Tournaments at Adda52 and win cash prizes worth lacs everyday.</p>
        <p>Thanks & Regards,<br>Team Adda52.com</p>
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
        echo 'Verification email couldn\'t be sent.';
    }
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>