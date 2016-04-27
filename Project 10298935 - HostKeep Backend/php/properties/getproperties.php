<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get json array of propertyIDs
$propertyIDs = json_decode($_POST['propertyIDs']);
$whereStatement = '';

// Add propertyIDs to whereStatement
foreach ($propertyIDs as $id) {
    $whereStatement .= 'propertyID = ' . $id . ' OR ';
}

// Remove the last OR
$whereStatement = substr($whereStatement, 0, -4);
$sql = "SELECT * FROM Properties WHERE " . $whereStatement;

// Execute query
if ($whereStatement != '') {
    if ($result = mysqli_query($con, $sql)) {
        $response = [];

        // Add results to an array
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }

        // Echo array as json
        echo json_encode($response);
    } else {
        sendErrorEmail("
        getproperties.php<br />
        sql: $sql
        ");
        echo 'fail';
    }
} else {
    echo json_encode([]);
}

mysqli_close($con);
?>
