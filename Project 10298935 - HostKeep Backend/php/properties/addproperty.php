<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$code = mysqli_real_escape_string($con, $_POST['propertyID']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$price = $_POST['price'];

$sql = "INSERT INTO Properties VALUES ('$code', '$username', '$name', '$description', '$address', '$price')";
$sql1 = "SELECT propertyIDs FROM Customer WHERE username = '$username'";
$sql2 = "UPDATE Customer SET propertyIDs = '$propertyIDs' WHERE username = '$username'";

// Insert property into database
if (mysqli_query($con, $sql)) {
    // Get the json array of propertyIDs for this username
    if ($result = mysqli_query($con, $sql1)) {
        // Add inserted propertyID into array
        $propertyIDs = json_decode(mysqli_fetch_assoc($result)['propertyIDs']);
        array_push($propertyIDs, $code);
        $propertyIDs = json_encode($propertyIDs);
        // Update customer record with updated propertyIDs json array and send propertyID back with response
        if (mysqli_query($con, "UPDATE Customer SET propertyIDs = '$propertyIDs' WHERE username = '$username'")) {
            echo 'success' . $code;
        } else {
            sendErrorEmail("
            addproperty.php<br />
            sql: $sql2
            ");
            echo 'fail update sql';
        }
    } else {
        sendErrorEmail("
        addproperty.php<br />
        sql: $sql1
        ");
        echo 'fail select sql';
    }
} else {
    sendErrorEmail("
    addproperty.php<br />
    sql: $sql
    ");
    echo 'fail insert sql';
}

mysqli_close($con);
?>
