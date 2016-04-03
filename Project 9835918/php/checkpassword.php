<?php
$config = parse_ini_file('/home/ccrsc638/config9835918.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

$password = mysqli_real_escape_string($con, $_POST['password']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Retrieve password for username entered
if ($result = mysqli_query($con, "SELECT password FROM Users WHERE username = '" . $username . "'")) {
    // Check if username exists in database
    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if password entered equals password in database for entered username
            if ($row['password'] == $password) {
                // Retrieve the accountType and expenses list
                if ($result2 = mysqli_query($con, "SELECT accountType, expenses FROM Users WHERE username = '" . $username . "'")) {
                    $response =  mysqli_fetch_assoc($result2);
                }
            } else {
                // If password is incorrect send back 'incorrectpassword'
                $response = 'incorrectpassword';
            }
        }
    } else {
        // If username doesn't exist send back 'nousername'
        $response = 'nousername';
    }
} else {
    $response = "Select query failed. SELECT password FROM Users WHERE username = '" . $username . "'";
}

echo json_encode($response);

mysqli_close($con);
?>