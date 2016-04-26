<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$testimonialID = $_POST['testimonialID'];
$sql = "DELETE FROM Testimonials WHERE testimonialID = $testimonialID";

if ($result = mysqli_query($con, "SELECT imageURL FROM Testimonials WHERE testimonialID = $testimonialID")) {
    $filename = "././uploads/" . mysqli_fetch_assoc($result)['imageURL'];
} else {
    $filename = '';
    echo 'select sql fail';
}

if ($result = mysqli_query($con, $sql)) {
    echo 'success';
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>