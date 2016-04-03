<?php
$config = parse_ini_file('/home/ccrsc638/config9835918.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);
 
$username = $_POST['username'];

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql = "DELETE FROM Users WHERE username = '" . $username . "'";
if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'Delete query failed.';
}

mysqli_close($con);
?>