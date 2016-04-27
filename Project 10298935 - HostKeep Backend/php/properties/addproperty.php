<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$name = $_POST['name'];
$description = $_POST['description'];
$address = $_POST['address'];
$price = $_POST['price'];



if (mysqli_query($con, "INSERT INTO Properties VALUES (default, $username, $name, $description, $address, $price)")) {
    if ($result = mysqli_query($con, "SELECT propertyIDs FROM Customer WHERE username = '$username'")) {
        $propertyIDs = json_decode(mysqli_fetch_assoc($result)['propertyIDs']);
        array_push($propertyIDs, mysqli_insert_id($con));
        $propertyIDs = json_encode($propertyIDs);
        if (mysqli_query($con, "UPDATE Customer SET propertyIDs = '$propertyIDs' WHERE username = '$username'")) {
            echo 'success';
        } else {
            echo 'fail update sql';
        }
    } else {
        echo 'fail select sql';
    }
} else {
    echo 'fail insert sql';
}

mysqli_close($con);
?>
