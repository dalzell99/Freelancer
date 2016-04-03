<?php
$config = parse_ini_file('/home/ccrsc638/config9808082.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($rows = mysqli_query($con, 'SELECT * FROM UserData')) {
    while ($row = mysqli_fetch_assoc($rows)) {
        $response[] = $row;
    }
    echo json_encode($response);
} else {
    echo 'Error executing select query';
}


?>