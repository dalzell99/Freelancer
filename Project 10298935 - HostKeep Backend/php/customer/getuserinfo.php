<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];

if ($result = mysqli_query($con, "SELECT * FROM Customer WHERE username = '$username'")) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo 'fail';
}

mysqli_close($con);
?>
