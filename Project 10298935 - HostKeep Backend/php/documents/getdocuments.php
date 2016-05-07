<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Documents WHERE username = '" . $_POST['username'] . "'";

if ($result = mysqli_query($con, $sql)) {
    $response = [];

    // Add results to an array
    while ($row = mysqli_fetch_assoc($result)) {
        $resultProp = mysqli_query($con, "SELECT name FROM Properties WHERE propertyID = '" . $row["propertyID"] . "'");
        $row['propertyName'] = mysqli_fetch_assoc($resultProp)['name'];

        $response[] = $row;
    }

    // Echo array as json
    echo json_encode($response);
} else {
    sendErrorEmail("
    getdocuments.php<br />
    sql: $sql
    ");
    echo json_encode('fail');
}

mysqli_close($con);
?>
