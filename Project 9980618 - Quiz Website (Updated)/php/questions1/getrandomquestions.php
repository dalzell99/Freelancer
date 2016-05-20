<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$numQuestions = $_POST['numQuestions'];
$category = $_POST['category'];

$sql = "SELECT question, answers, correctAnswer FROM Questions WHERE category = '$category' OR category = 'Miscellaneous'";
if ($result = mysqli_query($con, $sql)) {
    $response = [];
    while ($row = mysqli_fetch_array($result)) {
        $response[] = $row;
    }

    $test = [];
    for ($i = 0; $i < $numQuestions; $i += 1) {
        $index = rand(0, count($response) - 1);
        array_push($test, $response[$index]);
        array_splice($response, $index, 1);
    }

    echo json_encode(array('success', $test));
} else {
    echo 'fail';
}

mysqli_close($con);
?>
