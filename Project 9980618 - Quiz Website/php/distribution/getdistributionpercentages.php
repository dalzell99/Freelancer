<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Distribution";
if ($result = mysqli_query($con, $sql)) {
    echo json_encode(array('success', mysqli_fetch_assoc($result)));
} else {
    echo 'fail';
}

mysqli_close($con);
?>
