<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$numQuestions = $_POST['numQuestions'];
$category = $_POST['category'];

$sql = "SELECT * FROM Questions WHERE (category = '$category' OR category = 'Miscellaneous') AND creator = 'admin'";
if ($result = mysqli_query($con, $sql)) {
    $response = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }

    $questions = [];
    for ($i = 0; $i < $numQuestions; $i += 1) {
        $index = rand(0, count($response) - 1);
        array_push($questions, $response[$index]);

        // Delete question from database
        mysqli_query($con, "DELETE FROM Questions WHERE questionID = '" . $response[$index]['questionID'] . "'");

        // Delete question from question array
        array_splice($response, $index, 1);
    }

    echo json_encode(array('success', $questions));
} else {
    echo 'fail';
}

mysqli_close($con);
?>
