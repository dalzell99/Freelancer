<?php
require('../global.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "$beyondPricing/accounts",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "token: $beyondPricingAPIKey"
    ),
));

$response = json_decode(curl_exec($curl));
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    foreach ($response['listings'] as $property) {
        $sql = "UPDATE Properties SET beyondPricingID = '" . $property['id'] . "' WHERE airbnbURL = '" . $property['channel_id'] . "'";
        mysqli_query($con, $sql);
    }
}

mysqli_close($con);
?>
