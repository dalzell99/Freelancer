<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = md5($_POST['password'] . $username);

$sql = "SELECT password, loggedInToday FROM Users WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['password'] == $password) {
            if ($row['loggedInToday'] == 'n') {
                $sql3 = "UPDATE Users SET loggedInToday = 'y', freeUnconvertablePointsBalance = freeUnconvertablePointsBalance + 20 WHERE username = '$username'";
                mysqli_query($con, $sql3);
            }
            
            $sql2 = "SELECT userID, username, paidPointsBalance, freeConvertablePointsBalance, freeUnconvertablePointsBalance, email, emailConfirmed, notificationsArray, timeNotificationsViewed FROM Users WHERE username = '$username'";
            if ($result2 = mysqli_query($con, $sql2)) {
                $row2 = mysqli_fetch_assoc($result2);
                echo json_encode(array('correct', $row2));
            }
        } else {
            echo json_encode(array('incorrect', ''));
        }
    }
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>