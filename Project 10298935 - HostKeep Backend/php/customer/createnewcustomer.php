<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mt_rand(1000000, 9999999); // Create random 7 digit password

$sql = "INSERT INTO Customer(username, password) VALUES ('$email', '" . hashPassword($con, $password) . "')";

// Insert new customer
if ($result = mysqli_query($con, $sql)) {
    // Retrieve the welcome email which is stored in a separate html file
    require("../welcomeemail.php");

    // Send welcome email with login details
    if (sendEmail($email, $noReplyEmail, 'Welcome to HostKeep', $message)) {
        echo 'success';
    } else {
        sendErrorEmail("
        createnewcustomer.php<br />
        Mail Fail
        ");
        echo 'failmail';
    }
} else {
    sendErrorEmail("
    createnewcustomer.php<br />
    sql: $sql
    ");
    echo "fail";
}

mysqli_close($con);
?>
