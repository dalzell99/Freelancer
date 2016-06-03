<?php
require('../global.php');
require('../sendemail.php');
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
$admin = $_POST['admin'];
$username = $_POST['username'];
$propertyName = $_POST['propertyName'];

$sql = "INSERT INTO DirectBookings VALUES (DEFAULT, '$customerID', '$propertyID', '$guestName', '$guestMobile', '$guestEmail', '$guestCheckIn', '$guestCheckOut', '$invoiced', '$cleanUp', '$notes')";
if (mysqli_query($con, $sql)) {
    echo 'success' . mysqli_insert_id($con);

    if ($admin == 'true') {
        sendEmail($hostkeepEmail, $noReplyEmail, "New Direct Booking", "
        Username: $username <br />
        Property: $propertyName <br />
        Guest Name: $guestName <br />
        Guest Mobile: $guestMobile <br />
        Guest Email: $guestEmail <br />
        Check-in: " . substr($guestCheckIn, 6, 2) . '/' . substr($guestCheckIn, 4, 2) . '/' . substr($guestCheckIn, 0, 4) . "<br />
        Check-out: " . substr($guestCheckOut, 6, 2) . '/' . substr($guestCheckOut, 4, 2) . '/' . substr($guestCheckOut, 0, 4) . "<br />
        Invoiced: $invoiced <br />
        Cleanup: $cleanUp <br />
        Notes: $notes
        ");
    }
} else {
    echo 'fail';
    sendErrorEmail("
    addbooking.php<br />
    sql: $sql
    ");
}

mysqli_close($con);
?>
