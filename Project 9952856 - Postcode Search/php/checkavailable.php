<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$warehouse = mysqli_real_escape_string($con, $_POST['warehouse']);
$destination = mysqli_real_escape_string($con, $_POST['destination']);
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Users WHERE type = 'delivery' ORDER BY available DESC";

if ($result = mysqli_query($con, $sql)) {
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        $postcodes = json_decode($row['postcode1']);
        if (in_array($warehouse, $postcodes) != false && in_array($destination, $postcodes) != false) {
            $response[] = $row;
        }
    }
} else {
    $response = 'Select query failed';
}

echo json_encode($response);

mysqli_close($con);
?>