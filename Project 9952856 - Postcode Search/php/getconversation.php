<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = mysqli_real_escape_string($con, $_POST['username']);
$otherUser = mysqli_real_escape_string($con, $_POST['otherUser']);
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Messages WHERE (receiver = '$username' AND sender = '$otherUser') OR (receiver = '$otherUser' AND sender = '$username') ORDER BY timeSent DESC";

if ($result = mysqli_query($con, $sql)) {
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    
    $response = $messages;
} else {
    $response = 'Select query failed';
}

echo json_encode($response);

mysqli_close($con);
?>