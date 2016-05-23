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
    // Insert new customer
    if (sendWelcomeEmail($con, $row['username'])) {
        echo 'success';
    } else {
        sendErrorEmail("
        sendwelcomeemailtonewusers.php<br />
        Mail fail
        ");
        echo 'fail';
    }
}

mysqli_close($con);
?>
