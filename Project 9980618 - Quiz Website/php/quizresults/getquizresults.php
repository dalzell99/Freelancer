<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_POST['quizID'];

$sql = "SELECT * FROM QuizResults WHERE quizID = '$id' ORDER BY correctPercent DESC, timeTaken ASC";
$response = [];

if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Get the users profile image url and add to results
        $resultUser = mysqli_query($con, "SELECT imageURL FROM Users WHERE username = '" . $row['username'] . "'");
        $image = mysqli_fetch_assoc($resultUser)['imageURL'];
        if ($image == '') {
            // If the user doesn't have a profile image, show the default missing image
            $row['imageURL'] = 'missing.png';
        } else {
            $row['imageURL'] = $image;
        }
        $response[] = $row;
    }

    echo json_encode(array('success', $response));
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>
