<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Load API, Ideally it should installed by composer and autoloaded if your project uses composer
require('../razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

//Use your key_id and key secret
$api = new Api('rzp_test_DMtkjnzZPVHfJI', 'wCLQKYJvmzlgVC1NkmqfORV3');

//This is submited by the checkout form
if (isset($_POST['razorpay_payment_id']) === false) {
    die("Payment id not provided");
}

$id = $_POST['razorpay_payment_id'];
$paymentAmount = $_POST['amount'];
$numQuizzes = $_POST['numQuizzes'];
$userID = $_POST['userID'];
$username = $_POST['username'];

//capture payment amount
$payment = $api->payment->fetch($id)->capture(array('amount'=>$paymentAmount));

if ($payment['status'] == 'captured') {
    $sql = "UPDATE Users SET purchasedQuizzesRemaining = purchasedQuizzesRemaining + $numQuizzes, numQuizzesPurchased = numQuizzesPurchased + $numQuizzes WHERE userID = '$userID'";
    $sql2 = "SELECT email, username FROM Users WHERE userID = '$userID'";
    if (mysqli_query($con, $sql) && ($result = mysqli_query($con, $sql2))) {
        $row = mysqli_fetch_assoc($result);
        $to = array($row['email']);
        $from = $databasephpQuizMasterEmail;
        $subject = "Real Quizeto Purchase Completed";
        $message = "
        <html>
            <body>
                <p>Dear " . $row['username'] . ",</p>
                <p>You have successfully unlocked scheduling of $numQuizzes paid quizzes. Please login to your account and check the details under My Account--Quiz Master--Activate as Quiz master tabFor any concern please feel free to write us to quizmaster@iqzeto.com,</p>

                <p>We will be happy to assist</p>

                <p>Happy Quizzing</p>
                <p>RegardsTeam IQzeto</p>         </body>
        </html>
        ";

        $sendEmailResult = sendEmail($to, $from, $subject, $message);
        if ($sendEmailResult == 'success') {
            echo json_encode([$payment->toArray(), 'success']);
        } else {
            echo json_encode([$payment->toArray(), 'emailfail']);
        }
    } else {
        echo json_encode([$payment->toArray(), 'sqlfail', $sql]);
    }
} else {
    echo json_encode([$payment->toArray(), 'capturefail', $sql]);
}
?>
