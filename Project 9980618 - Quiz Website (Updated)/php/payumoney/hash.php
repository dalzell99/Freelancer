<?php
$MERCHANT_KEY = $_POST['key'];
$SALT = $_POST['salt'];
$txnid = $_POST['txnid'];
$amount = $_POST['amount'];
$productInfo = $_POST['productInfo'];
$firstname = $_POST['firstName'];
$email = $_POST['email'];

// Hash Sequence
$hash_string = "$MERCHANT_KEY|$txnid|$amount|$productInfo|$firstname|$email|||||||||||$SALT";
echo strtolower(hash('sha512', $hash_string));
?>
