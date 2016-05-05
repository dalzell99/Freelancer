<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "UPDATE Customer SET
        salutation = '" . $_POST['salutation'] . "',
        firstName = '" . mysqli_real_escape_string($con, $_POST['firstName']) . "',
        lastName = '" . mysqli_real_escape_string($con, $_POST['lastName']) . "',
        company = '" . mysqli_real_escape_string($con, $_POST['company']) . "',
        phoneNumber = '" . mysqli_real_escape_string($con, $_POST['telephone']) . "',
        mobileNumber = '" . mysqli_real_escape_string($con, $_POST['mobile']) . "',
        bankName = '" . mysqli_real_escape_string($con, $_POST['bankName']) . "',
        bsb = '" . mysqli_real_escape_string($con, $_POST['bsb']) . "',
        accountNumber = '" . mysqli_real_escape_string($con, $_POST['accountNumber']) . "',
        postalAddress = '" . mysqli_real_escape_string($con, $_POST['address']) . "',
        suburb = '" . mysqli_real_escape_string($con, $_POST['suburb']) . "',
        state = '" . mysqli_real_escape_string($con, $_POST['state']) . "',
        postcode = '" . mysqli_real_escape_string($con, $_POST['postcode']) . "',
        country = '" . mysqli_real_escape_string($con, $_POST['country']) . "',
        lastModified = '" . date('c') . "'
        WHERE username = '" . $_POST['username'] . "'";

if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    sendErrorEmail("
    saveprofilechanges.php<br />
    sql: $sql
    ");
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
