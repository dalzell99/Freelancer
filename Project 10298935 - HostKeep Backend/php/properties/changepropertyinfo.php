<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$propertyID = $_POST['propertyID'];
$column = $_POST['column'];
$value = $_POST['value'];

$sql = "UPDATE Properties SET $column = '$value' WHERE propertyID = '$propertyID'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';

    if ($_POST['admin'] != 'true') {
        $message = "
        Username: " . $_POST['username'] . "<br />
        Property Name: " . $_POST['propertyName'] . "<br />
        New Minimum Nightly Price: $$value
        ";

        if (!sendEmail($hostkeepEmail, 'HostKeep Owners Dashboard', 'Profile Changes', $message)) {
            sendErrorEmail("
            changepropertyinfo.php<br />
            Email Fail
            " . $message);
        }
    }
} else {
    sendErrorEmail("
    changepropertyinfo.php<br />
    sql: $sql
    ");
    echo 'fail';
}

mysqli_close($con);
?>
