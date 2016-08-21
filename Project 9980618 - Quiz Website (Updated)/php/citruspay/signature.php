<?php
// I don't know what this is for but it was in the sample code so I left it
$formPostUrl = "https://citruspay.com/sslperf/iqzeto";

//Need to change with your Secret Key
$secret_key = "a7cc8d093d0e2b1265078de13742b0e382f142ab"; // Live
// $secret_key = "ba9b96718d782755abf01a1f6809770bd28071c8"; // Test

//Need to change with your Vanity URL Key from the citrus panel
$vanityUrl = "iqzeto";

//Should be unique for every transaction
$merchantTxnId = (string)time();

//Need to change with your Order Amount
$orderAmount = $_GET['orderAmount'];
$currency = "INR";
$data = $vanityUrl . $orderAmount . $merchantTxnId . $currency;

$securitySignature = hash_hmac('sha1', $data, $secret_key);

echo json_encode(array($securitySignature, $merchantTxnId));
?>
