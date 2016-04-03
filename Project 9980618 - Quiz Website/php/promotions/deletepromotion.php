<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_POST['promotionID'];

$sql = "DELETE FROM Promotions WHERE promotionID = '$id'";

if (mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail';
}

mysqli_close($con);
?>