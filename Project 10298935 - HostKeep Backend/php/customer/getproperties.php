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

// Execute query
if ($result = mysqli_query($con, "SELECT * FROM Properties WHERE " . $whereStatement)) {
    $response = [];
    
    // Add results to an array
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    // Echo array as json
    echo json_encode($response);
} else {
    echo 'fail';
}

mysqli_close($con);
?>
