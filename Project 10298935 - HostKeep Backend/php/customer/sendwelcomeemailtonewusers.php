<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con, "SELECT username FROM Customer WHERE password = ''");
while ($row = mysqli_fetch_assoc($result)) {
    $randomPassword = substr(md5(rand()), 0, 7); // A random 7 character password
    $password = hashPassword($con, $randomPassword);

    mysqli_query($con, "UPDATE Customer SET password = '$password' WHERE username = '" . $row['username'] . "'");

    require("../welcomeemailtoadmincreatedusers.php");

    // Send welcome email with login details
    if (sendEmail($row['username'], $noReplyEmail, 'Welcome to HostKeep', $message)) {
        echo 'success';
    } else {
        sendErrorEmail("
        createnewcustomer.php<br />
        Mail Fail
        ");
        echo 'failmail';
    }
}

mysqli_close($con);
?>
