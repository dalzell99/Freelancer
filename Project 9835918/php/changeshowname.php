<?php
$config = parse_ini_file('/home/ccrsc638/config9835918.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

$newValue = mysqli_real_escape_string($con, $_POST['newValue']);
$oldValue = mysqli_real_escape_string($con, $_POST['oldValue']);

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "UPDATE ShowNames SET showName = '" . $newValue . "' WHERE showName = '" . $oldValue . "'")) {
    echo 'success';
} else {
    echo 'Update query failed';
}

mysqli_close($con);
?>