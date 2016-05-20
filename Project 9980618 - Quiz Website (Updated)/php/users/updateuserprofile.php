<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$DOB = $_POST['DOB'];
$mobileAlt = $_POST['mobileAlt'];
$address = $_POST['address'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$state = $_POST['state'];
$country = $_POST['country'];
$pancard = $_POST['pancard'];

$sql = "UPDATE Users SET
firstName = '$firstName',
lastName = '$lastName',
gender = '$gender',
DOB = '$DOB',
mobileAlt = '$mobileAlt',
homeAddress = '$address',
city = '$city',
pincode = '$pincode',
state = '$state',
country = '$country',
pancard = '$pancard'
WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
