<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = mysqli_real_escape_string($con, $_POST['username']);
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "SELECT * FROM Messages WHERE receiver = '$username' OR sender = '$username' ORDER BY timeSent DESC")) {
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