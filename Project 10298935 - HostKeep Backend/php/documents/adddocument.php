<?php
require_once('../global.php');
require_once('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$name = mysqli_real_escape_string($con, $_POST['name']);
$propertyID = $_POST['propertyID'];
$month = $_POST['month'];
$dateUploaded = date('c');
$notes = mysqli_real_escape_string($con, $_POST['notes']);
$filename = $_POST['filename'];

$sql = "INSERT INTO Documents VALUES (DEFAULT, '$username', '$name', '$propertyID', '$month', '$dateUploaded', '$notes', '$filename')";

// Insert document into database
if (mysqli_query($con, $sql)) {
    // Get documentID of last insert document
    echo 'success' . mysqli_insert_id($con);
} else {
    sendErrorEmail("
    adddocument.php<br />
    sql: $sql
    ");
    echo 'fail insert sql';
}

mysqli_close($con);
?>
