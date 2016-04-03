<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = mysqli_real_escape_string($con, $_POST['username']);
$postcode = json_encode($_POST['postcode']);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "UPDATE Users SET postcode1 = '$postcode' WHERE username = '$username'";

if ($result = mysqli_query($con, $sql)) {
    /* fetch associative array */
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>