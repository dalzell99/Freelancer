<?php
require('database.php');
require('sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Load API, Ideally it should installed by composer and autoloaded if your project uses composer
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

//Use your key_id and key secret
$api = new Api('rzp_test_DMtkjnzZPVHfJI', 'wCLQKYJvmzlgVC1NkmqfORV3');

//This is submited by the checkout form
if (isset($_POST['razorpay_payment_id']) === false) {
    die("Payment id not provided");
}

$id = $_POST['razorpay_payment_id'];
$paymentAmount = $_POST['paymentAmount'];
$userID = $_POST['userID'];
$username = $_POST['username'];

//capture payment amount
$payment = $api->payment->fetch($id)->capture(array('amount'=>$paymentAmount));

if ($payment['status'] == 'captured') {
    $sql = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . ($paymentAmount / 100) . " WHERE userID = '$userID'";
    $sql2 = "SELECT email, username FROM Users WHERE userID = '$userID'";
    $sql3 = "INSERT INTO Purchases VALUES (default, '$userID', '$username', '" . ($paymentAmount / 100) . "', '" . date('c') . "')";
    if (mysqli_query($con, $sql) && ($result = mysqli_query($con, $sql2)) && mysqli_query($con, $sql3)) {
        $row = mysqli_fetch_assoc($result);
        $to = array($row['email']);
        $from = $databasephpNoReplyEmail;
        $subject = "Real Quizeto Purchase Completed";
        $message = "
        <html>
            <body>
                <p>Dear " . $row['username'] . ",<br>Thank you for your purchase on IQzeto.com! " . $paymentAmount / 100 . " Real Quizetos have been added to your account and are ready to be used.</p>
                <p>Thanks & Regards,<br>Team IQzeto.com</p>
            </body>
        </html>
        ";

        $sendEmailResult = sendEmail($to, $from, $subject, $message);
        if ($sendEmailResult == 'success') {
            echo json_encode([$payment->toArray(), 'success']);
        } else {
            echo json_encode([$payment->toArray(), 'emailfail']);
        }
    } else {
        //echo response
        echo json_encode([$payment->toArray(), 'sqlfail', $sql]);
    }
} else {
    echo json_encode([$payment->toArray(), 'capturefail', $sql]);
}
?>
