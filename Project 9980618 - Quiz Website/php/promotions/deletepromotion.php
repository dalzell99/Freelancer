<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id = $_POST['promotionID'];
$sql = "DELETE FROM Promotions WHERE promotionID = '$id'";

if ($result = mysqli_query($con, "SELECT imageURL FROM Promotions WHERE promotionID = '$id'")) {
    $filename = "././uploads/" . mysqli_fetch_assoc($result)['imageURL'];
} else {
    $filename = '';
    echo 'select sql fail';
}

if (mysqli_query($con, $sql)) {
    if ($filename != '' && $filename != "././uploads/" && file_exists($filename) && unlink($filename)) {
        echo 'success';
    } else {
        echo 'delete file fail.';
    }
} else {
    echo 'delete sql fail';
}

mysqli_close($con);
?>