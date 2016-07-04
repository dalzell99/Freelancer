<?php

require '../global.php';
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo 'Failed to connect to MySQL: '.mysqli_connect_error();
}

$sql = 'SELECT beyondPricingID FROM Properties';
if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$beyondPricing/listings/" . $row['beyondPricingID'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                "token: $beyondPricingAPIKey",
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {
            $sqlUpdate = "UPDATE Properties SET basePrice = " . $response['base_price'] . ", minimumNightlyPrice = " . $response['min_price'] . " WHERE beyondPricingID = " . $row['beyondPricingID'];
            mysqli_query($con, $sqlUpdate);
        }
    }
} else {
    echo 'fail';
}

mysqli_close($con);
