<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$propertyID = $_POST['propertyID'];
$price = $_POST['price'];

if ($result = mysqli_query($con, "UPDATE Properties SET minimumNightlyPrice = '$price' WHERE propertyID = '$propertyID'")) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
