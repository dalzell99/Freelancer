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
$sql1 = "SELECT documentIDs FROM Customer WHERE username = '$username'";
$sql2 = "UPDATE Customer SET documentIDs = '$documentIDs' WHERE username = '$username'";

// Insert document into database
if (mysqli_query($con, $sql)) {
    // Get documentID of last insert document
    $id = mysqli_insert_id($con);

    // Get the json array of documentIDs for this username
    if ($result = mysqli_query($con, $sql1)) {
        // Add inserted documentID into array
        $documentIDs = json_decode(mysqli_fetch_assoc($result)['documentIDs']);
        array_push($documentIDs, $id);
        $documentIDs = json_encode($documentIDs);
        // Update customer record with updated documentIDs json array and send documentID back with response
        if (mysqli_query($con, "UPDATE Customer SET documentIDs = '$documentIDs' WHERE username = '$username'")) {
            echo 'success' . $id;
        } else {
            sendErrorEmail("
            adddocument.php<br />
            sql: $sql2
            ");
            echo 'fail update sql';
        }
    } else {
        sendErrorEmail("
        adddocument.php<br />
        sql: $sql1
        ");
        echo 'fail select sql';
    }
} else {
    sendErrorEmail("
    adddocument.php<br />
    sql: $sql
    ");
    echo 'fail insert sql';
}

mysqli_close($con);
?>
