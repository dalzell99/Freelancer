<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$testimonialID = $_POST['testimonialID'];
$username = mysqli_real_escape_string($con, $_POST['username']);
$message = mysqli_real_escape_string($con, $_POST['message']);

$sql = "UPDATE Testimonials SET username = '$username', message = '$message' WHERE testimonialID = $testimonialID";

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>