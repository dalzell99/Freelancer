<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$password = $_POST['newPassword'];
$sql = "UPDATE Users SET password = '$password' WHERE username = '$username' AND email = '$email'";

$to = $email;
$from = 'forgotpassword@ccrscoring.co.nz';
$subject = "Forgot Password";
$message = "
<html>
    <body>
        <p>Dear " . $username . ",<br>Click the link below to change your password:</p>
        <p><a href='http://ccrscoring.co.nz/9980618/forgotpassword.php?username=" . $username . "&password=" . $password . "'>Click here to change your password</a></p>
        <p>You can also copy and paste the above link in the address bar of your browser to change your password.</p>
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
        echo 'email fail.';
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>