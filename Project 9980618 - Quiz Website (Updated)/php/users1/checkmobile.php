<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$userID = mysqli_real_escape_string($con, $_POST['userID']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);

$sql = "SELECT userID FROM Users WHERE userID = '$userID' AND mobile = '$mobile'";

if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo 'correct';
    } else {
        echo 'incorrect';
    }
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>