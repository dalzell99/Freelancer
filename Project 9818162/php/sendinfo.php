<?php
$to = "email@aussie961.com";
//$to = "cfd19@hotmail.co.nz";
$subject = "Time status";

$message = "
<html>
    <head>
        <title></title>
    </head>
    <body>
        <p>Time: " . $_POST['time'] . "</p>
        <p>Status: " . $_POST['status'] . "</p>
        <p>Address: " . $_POST['address'] . "</p>
        <p>Longitude: " . $_POST['lon'] . "</p>
        <p>Latitude: " . $_POST['lat'] . "</p>
        <p>Accuracy: " . $_POST['accuracy'] . "m</p>
    </body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
//$headers .= "From: " . $_POST['email'] . "\r\n";

if (mail($to,$subject,$message,$headers)) {
    echo 'success';
} else {
    echo 'fail';
}
?>