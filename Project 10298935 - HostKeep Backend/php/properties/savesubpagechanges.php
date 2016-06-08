<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "UPDATE Properties SET
name = '" . mysqli_real_escape_string($con, $_POST['name']) . "',
description = '" . mysqli_real_escape_string($con, $_POST['description']) . "',
address = '" . mysqli_real_escape_string($con, $_POST['address']) . "',
basePrice = '" . mysqli_real_escape_string($con, $_POST['basePrice']) . "',
minimumNightlyPrice = '" . mysqli_real_escape_string($con, $_POST['minimumNightlyPrice']) . "',
commencementDate = '" . mysqli_real_escape_string($con, $_POST['commencementDate']) . "',
propertyFee = '" . mysqli_real_escape_string($con, $_POST['propertyFee']) . "',
cleaningFee = '" . mysqli_real_escape_string($con, $_POST['cleaningFee']) . "',
airbnbURL = '" . mysqli_real_escape_string($con, $_POST['airbnbURL']) . "',
guestGreetURL = '" . mysqli_real_escape_string($con, $_POST['guestGreetURL']) . "',
selfCheckinURL = '" . mysqli_real_escape_string($con, $_POST['selfCheckinURL']) . "',
status = '" . $_POST['status'] . "',
commencementFee = '" . mysqli_real_escape_string($con, $_POST['commencementFee']) . "',
commencementFeeReceived = '" . mysqli_real_escape_string($con, $_POST['commencementFeeReceived']) . "'
WHERE propertyID = '" . $_POST['propertyID'] . "'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    sendErrorEmail("
    savesubpagechanges.php<br />
    sql: $sql
    ");
    echo 'fail';
}

mysqli_close($con);
?>
