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
$accountNum = mysqli_real_escape_string($con, $_POST['accountNum']);
$code = mysqli_real_escape_string($con, $_POST['code']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$pancard = mysqli_real_escape_string($con, $_POST['pancard']);
$method = $_POST['method'];

$sql = "SELECT paidPointsBalance, email FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['paidPointsBalance'] >= $amount) {
        $email = $row['email'];
        $sqlConvert = "UPDATE Users SET pancard = '$pancard', paidPointsBalance = paidPointsBalance - " . $amount . " WHERE username = '$username'";
        $sqlWithdrawal = "INSERT INTO Withdrawal VALUES (Default, '$username', $amount, 'banktransfer', '$phone', '$email', '', '$accountNum', '$code', '" . date('c') . "', 'n', '$pancard')";
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
                    <p>Bank Account Number: $accountNum</p>
                    <p>IFSC Code: $code</p>
                </body>
            </html>
            ";

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
