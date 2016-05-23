<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$customerID = $_POST['customerID'];
$status = $_POST['status'];

// Get status before changing it
$sqlUser = "SELECT status, username FROM Customer WHERE customerID = '$customerID'";
if ($resultUser = mysqli_query($con, $sqlUser)) {
    $sql = "UPDATE Customer SET status = '$status' WHERE customerID = '$customerID'";
    if ($result = mysqli_query($con, $sql)) {
        // check if status was changed from proposal to active.
        $rowUser = mysqli_fetch_assoc($resultUser);
        if ($rowUser['status'] == 'proposal' && $status == 'active') {
            // If yes then send welcome email
            if (sendWelcomeEmail($con, $rowUser['username'])) {
                echo 'success';
            } else {
                sendErrorEmail("
                changestatus.php<br />
                Mail fail
                ");
                echo 'fail';
            }
        } else {
            // If not, then echo success
            echo 'success';
        }
    } else {
        sendErrorEmail("
        changestatus.php<br />
        SQL: $sql
        ");
        echo 'fail' . $sql;
    }
}

mysqli_close($con);
?>
