<?php
//Need to replace the last part of URL("your-vanityUrlPart") with your Testing/Live URL
$formPostUrl = "https://citruspay.com/sslperf/iqzeto";

//Need to change with your Secret Key
$secret_key = "a7cc8d093d0e2b1265078de13742b0e382f142ab";

//Need to change with your Vanity URL Key from the citrus panel
$vanityUrl = "iqzeto";

//Should be unique for every transaction
$merchantTxnId = (string)mktime();

//Need to change with your Order Amount
$orderAmount = $_GET['orderAmount'];
$currency = "INR";
$data = $vanityUrl . $orderAmount . $merchantTxnId . $currency;

$securitySignature = hash_hmac('sha1', $data, $secret_key);

echo json_encode(array($securitySignature, $merchantTxnId));
?>
