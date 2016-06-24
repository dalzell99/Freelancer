<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "SELECT * FROM QuizMaster WHERE id = 1")) {
    echo json_encode(mysqli_fetch_assoc($result));
} else {
    echo 'fail';
}

mysqli_close($con);
?>
