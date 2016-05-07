<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$code = mysqli_real_escape_string($con, $_POST['propertyID']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$price = $_POST['price'];

$sql = "INSERT INTO Properties VALUES ('$code', '$username', '$name', '$description', '$address', '$price')";

// Insert property into database
if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    sendErrorEmail("
    addproperty.php<br />
    sql: $sql
    ");
    echo 'fail insert sql';
}

mysqli_close($con);
?>
