<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$first = $_POST['first'];
$second = $_POST['second'];
$third = $_POST['third'];

$sql = "UPDATE Distribution SET first = $first, second = $second, third = $third WHERE distributionID = 1";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>
