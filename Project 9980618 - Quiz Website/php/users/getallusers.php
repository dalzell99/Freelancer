<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT userID, username, paidPointsBalance, freeConvertablePointsBalance, freeUnconvertablePointsBalance, email, homeAddress FROM Users";
$sql2 = "SELECT * FROM ConversionRate";
$response = [];

if (($result = mysqli_query($con, $sql)) && ($result2 = mysqli_query($con, $sql2))) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    
    echo json_encode(array('success', $response, mysqli_fetch_assoc($result2)));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>