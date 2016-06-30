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
$password = $_POST['newPassword'];
$sql = "UPDATE Users SET password = '$password' WHERE username = '$username' AND email = '$email'";
$resultUser = mysqli_query($con, "SELECT userID FROM Users WHERE username = '$username' AND email = '$email'");

if (mysqli_num_rows($resultUser) > 0) {
    $to = array($email);
    $from = $databasephpNoReplyEmail;
    $subject = "Forgot Password";
    $message = "
    <html>
        <body>
            <p>Dear " . $username . ",<br>Click the link below to change your password:</p>
            <p><a href='https://www.iqzeto.com/forgot-password.php?username=" . $username . "&password=" . $password . "'>https://www.iqzeto.com/forgot-password.php?username=" . $username . "&password=" . $password . "</a></p>
            <p>You can also copy and paste the above link in the address bar of your browser to change your password.</p>
            <p>Thanks & Regards,<br>Team IQzeto.com</p>
        </body>
    </html>
    ";

    if (mysqli_query($con, $sql)) {
        $sendEmailResult = sendEmail($to, $from, $subject, $message);
        if ($sendEmailResult == 'success') {
            echo 'success';
        } else {
            echo 'email fail.';
        }
    } else {
        echo 'fail' . $sql;
    }
} else {
    echo 'incorrect';
}

mysqli_close($con);
?>
