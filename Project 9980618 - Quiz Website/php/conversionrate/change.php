<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$rate = $_POST['rate'];

$sql = "UPDATE ConversionRate SET rate = $rate WHERE rateID = 1";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail. ' . $sql;
}

mysqli_close($con);
?>