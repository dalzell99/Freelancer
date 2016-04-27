<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = hashPassword($con, $_POST['password']);

$sql = "SELECT * FROM Customer WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result) == 0) {
        echo 'incorrectusername';
    } else {
        $assoc = mysqli_fetch_assoc($result);
        if ($assoc['lastLogin'] == '') {
            mysqli_query($con, "UPDATE Customer SET lastLoginIP = '" . $_SERVER['REMOTE_ADDR'] . "', lastLogin = '" . date('c') . "' WHERE username = '$username'");
            echo 'firsttime' . json_encode($assoc);
        } else if ($assoc['password'] == $password) {
            mysqli_query($con, "UPDATE Customer SET lastLoginIP = '" . $_SERVER['REMOTE_ADDR'] . "', lastLogin = '" . date('c') . "' WHERE username = '$username'");
            echo 'correct' . json_encode($assoc);
        } else {
            echo 'incorrectpassword';
        }
    }
} else {
    sendErrorEmail("
    login.php<br />
    sql: $sql
    ");
    echo 'fail';
}

mysqli_close($con);
?>
