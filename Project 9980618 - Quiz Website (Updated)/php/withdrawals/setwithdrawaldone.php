<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$done = $_POST['done'];
$id = $_POST['withdrawalID'];
$username = $_POST['username'];
$amount = $_POST['amount'];

$sql = "UPDATE Withdrawal SET done = '$done' WHERE withdrawalID = '$id'";
$sqlDone = "SELECT email FROM Users WHERE username = '$username'";

if (mysqli_query($con, $sql) && ($result = mysqli_query($con, $sqlDone))) {
    if ($done == 'y') {
        $to = mysqli_fetch_assoc($result)['email'];
        $from = $databasephpNoReplyEmail;
        $subject = "IQzeto Withdrawal Processed";
        $message = "
        <html>
            <body>
                <p>Dear $username,<br>
                Your IQzeto withdrawal of ₹$amount has been processed. You should received it soon.<br><br>

                Thanks,
                <br>IQzeto.com Team</p>
            </body>
        </html>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= "From: " . $from . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo 'success';
        } else {
            echo 'emailerror';
        }
    } else {
        echo 'success';
    }
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>
