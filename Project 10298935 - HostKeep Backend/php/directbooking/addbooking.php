<?php
require('../global.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$customerID = $_POST['customerID'];
$propertyID = $_POST['propertyID'];
$guestName = $_POST['guestName'];
$guestMobile = $_POST['guestMobile'];
$guestEmail = $_POST['guestEmail'];
$guestCheckIn = $_POST['guestCheckIn'];
$guestCheckOut = $_POST['guestCheckOut'];
$invoiced = $_POST['invoiced'];
$cleanUp = $_POST['cleanUp'];
$notes = $_POST['notes'];

$sql = "INSERT INTO DirectBookings VALUES (DEFAULT, '$customerID', '$propertyID', '$guestName', '$guestMobile', '$guestEmail', '$guestCheckIn', '$guestCheckOut', '$invoiced', '$cleanUp', '$notes')";
if (mysqli_query($con, $sql)) {
    echo 'success' . mysqli_insert_id($con);
} else {
    echo 'fail';
    sendErrorEmail("
    addbooking.php<br />
    sql: $sql
    ");
}

mysqli_close($con);
?>
