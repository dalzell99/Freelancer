<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$name = mysqli_real_escape_string($con, $_POST['name']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$pancard = mysqli_real_escape_string($con, $_POST['pancard']);
$method = $_POST['method'];

$sql = "SELECT paidPointsBalance, email FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['paidPointsBalance'] >= $amount) {
        $email = $row['email'];
        $sqlConvert = "UPDATE Users SET pancard = '$pancard', paidPointsBalance = paidPointsBalance - " . $amount . " WHERE username = '$username'";
        $sqlWithdrawal = "INSERT INTO Withdrawal VALUES (Default, '$username', $amount, 'cheque', '$phone', '$email', '$address', '', '', '" . date('c') . "', 'n', '$pancard')";
        if (mysqli_query($con, $sqlConvert) && mysqli_query($con, $sqlWithdrawal)) {
            $to = array($databasephpWithdrawalEmail, $email);
            $from = $databasephpNoReplyEmail;
            $subject = "IQzeto Withdrawal";
            $message = "
            <html>
                <body>
                    <p>Method: $method</p>
                    <p>Amount: ₹$amount</p>
                    <p>Name: $name</p>
                    <p>Username: $username</p>
                    <p>Phone Number: $phone</p>
                    <p>Email: $email</p>
                    <p>Address: $address</p>
                </body>
            </html>
            ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= "From: " . $from . "\r\n";

            $sendEmailResult = sendEmail($to, $from, $subject, $message);
            if ($sendEmailResult == 'success') {
                echo 'success';
            } else {
                $sqlConvert = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $amount . " WHERE username = '$username'";
                mysqli_query($con, $sqlConvert);
                echo 'emailerror';
            }
        } else {
            echo 'sql fail. ' . $sqlConvert . ', ' . $sqlWithdrawal;
        }
    } else {
        echo 'notenoughpoints';
    }
} else {
    echo 'sql fail. ' . $sql;
}

mysqli_close($con);
?>
