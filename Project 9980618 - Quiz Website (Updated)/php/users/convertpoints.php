<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = $_POST['userID'];
$username = $_POST['username'];
$points = $_POST['freePoints'];

$sql = "SELECT freeConvertablePointsBalance FROM Users WHERE userID = '$userID'";
$resultRate = mysqli_query($con, "SELECT rate FROM ConversionRate");
$rate = mysqli_fetch_assoc($resultRate)['rate'];

if ($result = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['freeConvertablePointsBalance'] >= $points && $points > $rate) {
        $change = floor($points / $rate);
        $sqlConvert = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $change . ", freeConvertablePointsBalance = freeConvertablePointsBalance - " . ($change * $rate) . " WHERE userID = '$userID'";
        $sqlConversion = "INSERT INTO Conversions VALUES (default, '$username', '" . date('c') . "', $points, $change)";
        if (mysqli_query($con, $sqlConvert) && mysqli_query($con, $sqlConversion)) {
            echo "success$change";
        } else {
            echo "fail $sqlConvert $sqlConversion";
        }
    } else {
        echo 'notenoughpoints';
    }
} else {
    echo 'sql fail. ' . $sql;
}

mysqli_close($con);
?>
