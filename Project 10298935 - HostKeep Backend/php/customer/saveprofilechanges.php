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
        firstName = '" . $_POST['firstName'] . "',
        lastName = '" . $_POST['lastName'] . "',
        company = '" . $_POST['company'] . "',
        phoneNumber = '" . $_POST['telephone'] . "',
        mobileNumber = '" . $_POST['mobile'] . "',
        bankName = '" . $_POST['bankName'] . "',
        bsb = '" . $_POST['bsb'] . "',
        accountNumber = '" . $_POST['accountNumber'] . "',
        postalAddress = '" . $_POST['address'] . "',
        suburb = '" . $_POST['suburb'] . "',
        state = '" . $_POST['state'] . "',
        postcode = '" . $_POST['postcode'] . "',
        country = '" . $_POST['country'] . "',
        lastModified = '" . date('c') . "'
        WHERE username = '" . $_POST['username'] . "'";

if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
