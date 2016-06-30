<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$email = mysqli_real_escape_string($con, $_POST['email']);
$emailCode = $_POST['code'];
$sql = "UPDATE Users SET email = '$email', emailConfirmed = '$emailCode' WHERE userID = $userID";

$to = array($email);
$from = $databasephpNoReplyEmail;
$subject = "IQzeto Verification Email";
$message = "
<html>
    <body>

        <p><b>Greetings $username,</b></p>

        <p><a href='https://www.iqzeto.com/emailverification.php?email=$email&code=$emailCode'>Click here to verify your email address</a></p>


        <p><b>Regards</b></p>

        <p><b>Team IQzeto</b> </p>
    </body>
</html>
";

if (mysqli_query($con, $sql)) {
    $sendEmailResult = sendEmail($to, $from, $subject, $message);
    if ($sendEmailResult == 'success') {
        echo 'success';
    } else {
        echo 'mail fail';
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
