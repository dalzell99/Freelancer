<?php
$config = parse_ini_file('/home/ccrsc638/config9835918.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

$type = mysqli_real_escape_string($con, $_POST['type']);
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO ExpenseTypes VALUES ('" . $type . "')";

// Retrieve password for username entered
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo "Insert query failed. " . $sql;
}

mysqli_close($con);
?>