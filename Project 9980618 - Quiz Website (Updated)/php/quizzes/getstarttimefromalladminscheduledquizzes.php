<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "SELECT startTime FROM Quizzes WHERE creatorUsername = 'admin'")) {

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    echo json_encode($response);
} else {
    echo 'fail';
}

mysqli_close($con);
?>
