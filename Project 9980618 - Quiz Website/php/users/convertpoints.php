<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$points = $_POST['freePoints'];

$sql = "SELECT freeConvertablePointsBalance FROM Users WHERE userID = '$userID'";
$resultRate = mysqli_query($con, "SELECT rate FROM ConversionRate");
$rate = mysqli_fetch_assoc($resultRate)['rate'];

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['freeConvertablePointsBalance'] >= $points) {
        $sqlConvert = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . ($points / $rate) . ", freeConvertablePointsBalance = freeConvertablePointsBalance - " . $points . " WHERE userID = '$userID'";
        if (mysqli_query($con, $sqlConvert)) {
            echo 'success'. ($points / $rate);
        } else {
            echo 'sql fail. ' . $sqlConvert;
        }
    } else {
        echo 'notenoughpoints';
    }
} else {
    echo 'sql fail. ' . $sql;
}

mysqli_close($con);
?>