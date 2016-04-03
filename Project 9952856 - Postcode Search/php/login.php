<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);
$response = [];

// Check connection
if (mysqli_connect_errno()) {
    array_push($response, "Failed to connect to MySQL: " . mysqli_connect_error());
}

if ($result = mysqli_query($con, "SELECT * FROM Users")) {
    $usernameFound = false;
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['username'] == $username) {
            $usernameFound = true;
            if ($password == $row['password']) {
                array_push($response, 'correct');
                array_push($response, $row['type']);
                array_push($response, $row['postcode1']);
            } else {
                array_push($response, 'incorrect');
            }
        }
    }
    
    if ($usernameFound == false) {
        array_push($response, 'usernamenotfound');
    }
} else {
    array_push($response, 'Select query failed');
}

echo json_encode($response);

mysqli_close($con);
?>