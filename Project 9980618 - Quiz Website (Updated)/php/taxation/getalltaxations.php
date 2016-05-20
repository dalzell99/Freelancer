<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM Taxation";
if ($result = mysqli_query($con, $sql)) {
    $response = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // Get the current pancard associated with the user in each taxation
        $resultUser = mysqli_query($con, "SELECT pancard FROM Users WHERE username = '" . $row['username'] . "'");
        // Add the pancard to the current taxation assoc array
        $row['pancard'] = mysqli_fetch_assoc($resultUser)['pancard'];
        $response[] = $row;
    }

    echo json_encode($response);
} else {
    echo 'fail';
}

mysqli_close($con);
?>
