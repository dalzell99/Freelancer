<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Testimonials";
$response = [];

if ($result = mysqli_query($con, $sql)) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    
    echo json_encode(array('success', $response));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>