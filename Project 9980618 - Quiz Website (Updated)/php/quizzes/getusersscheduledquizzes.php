<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_GET['username'];

$sql = "SELECT * FROM Quizzes WHERE creatorUsername = '$username'";
if ($result = mysqli_query($con, $sql)) {
    $response = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $sqlWinner = "SELECT username FROM Users WHERE userID = " . $row['winningUserID'];
        $resultWinner = mysqli_query($con, $sqlWinner);
        $row['winner'] = mysqli_fetch_assoc($resultWinner)['username'];
        $response[] = $row;
    }

    echo json_encode($response);
} else {
    echo 'fail';
}

mysqli_close($con);
?>
