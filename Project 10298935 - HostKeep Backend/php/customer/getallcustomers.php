<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT username FROM Customer";

if ($result = mysqli_query($con, $sql)) {
    $response = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);
} else {
    sendErrorEmail("
    getallcustomers.php<br />
    sql: $sql
    ");
    echo 'fail';
}

mysqli_close($con);
?>
