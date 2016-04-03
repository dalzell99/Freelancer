<?php
$config = parse_ini_file('/home/ccrsc638/config9808082.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$postcode = mysqli_real_escape_string($con, $_POST['postcode']);
$mensgear = $_POST['mensgear'];
$womensgear = $_POST['womensgear'];

// Update game element with new values
$insert = "INSERT INTO UserData VALUES ('$name', '$email', '$postcode', '$mensgear', '$womensgear')";

if (mysqli_query($con, $insert)) {
    echo 'success';
} else {
    echo 'insert query failed' . $insert;
}

mysqli_close($con);
?>