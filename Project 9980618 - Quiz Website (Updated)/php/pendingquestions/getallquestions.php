<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM PendingQuestions WHERE rejected = 'n'";
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    echo json_encode(['success', $response]);
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
