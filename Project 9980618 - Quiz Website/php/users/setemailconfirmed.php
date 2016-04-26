<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = $_POST['email'];
$emailCode = $_POST['emailCode'];

$sqlSelect = "SELECT emailConfirmed FROM Users WHERE email = '$email'";

if ($result = mysqli_query($con, $sqlSelect)) {
    $row = mysqli_fetch_assoc($result);
    if ($row['emailConfirmed'] == $emailCode) {
        if (mysqli_query($con, "UPDATE Users SET emailConfirmed = 'y' WHERE email = '$email'")) {
            echo 'success';
        } else {
            echo 'fail. ' . "UPDATE Users SET emailConfirmed = 'y' WHERE email = '$email'";
        }
    } else {
        echo 'incorrect';
    }
} else {
    echo 'fail. ' . $sqlSelect;
}

mysqli_close($con);
?>