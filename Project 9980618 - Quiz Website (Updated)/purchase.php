<?php include('header.php'); ?>
<?php
echo '<script type="text/javascript" src="js/myaccount.js?' . filemtime('js/myaccount.js') . '"></script>';
?>

<?php
$orderAmount = $_GET['orderAmount'];
$currency = "INR";
$email = $_GET['email'];
$mobile = $_GET['mobile'];
$merchantTxnId = mktime();
$merchantAccessKey = "2IVQIMKCXK5MHOOL3IIK";
$secret_key = "ba9b96718d782755abf01a1f6809770bd28071c8";
$vanityUrl = "iqzeto";
$mode = "dropIn";

$data = $vanityUrl . $orderAmount . $merchantTxnId . $currency;

$secSignature = hash_hmac('sha1', $data, $secret_key);
?>

<form align="center" id="walletUrl">
    Email: <input name="email" id="email" type="text" value="<?php echo $email ?>" /> <br />
    Mobile: <input name="mobile" id="mobile" type="text" value="<?php echo $mobile ?>" /> <br />
    Access Key: <input name="merchantAccessKey" type="text" id="merchantAccessKey" value="<?php echo $merchantAccessKey ?>" /> <br />
    Amount: <input name="amount" id="orderAmount" type="text" value="<?php echo $orderAmount ?>" /> <br />
    Mode: <input name="mode" id="mode" type="text" value="<?php echo $mode ?>" /> <br />
    Currency: <input name="currency" id="currency" type="text" value="<?php echo $currency ?>" /> <br />
    Signature: <input name="secSignature" id="secSignature" type="text" value="<?php echo $secSignature ?>" /> <br />
    Merchant TXN ID: <input name="merchantTxnId" id="merchantTxnId" type="text" value="<?php echo $merchantTxnId ?>" /> <br />
    Vanity: <input name="vanityUrl" id="vanityUrl" type="text" value= "<?php echo $vanityUrl ?>" > <br />
    Notify URL: <input name="notifyUrl" id="notifyUrl" type="text" value="https://stgpg5.citruspay.com/icpkit/jsp/TestNotifyResponse.jsp"> <br />
    Return URL: <input name="returnUrl" id="returnUrl" type="text" value="http://localhost/citrus-hosted/result.php"> <br />
</form >

<script type="text/javascript">
//write code to start loader citrusICP.launchIcp
$(function() {
    citrusICP.launchIcp({
        orderAmount: $('#orderAmount').val(),
        currency: $('#currency').val(),
        phoneNumber: $('#mobile').val(),
        email: $('#email').val(),
        merchantAccessKey: $('#merchantAccessKey').val(),
        merchantTxnId: $('#merchantTxnId').val(),
        returnUrl: $('#returnUrl').val(),
        secSignature: $('#secSignature').val(),
        notifyUrl: $('#notifyUrl').val(),
        vanityUrl: $('#vanityUrl').val(),
        mode: $('#mode').val(),
        addressStreet1: "street1",
        addressStreet2: "street2",
        addressCity: "Mumbai",
        addressState: "MH",
        addressCountry: "India",
        addressZip: "400605",
        firstName: "Chris",
        lastName: "Dalzell"
    },
    {
        icpUrl: "http://sboxcontext.citruspay.com/kiwi/kiwi-popover",
        eventHandler: function(cbObj) {
            if (cbObj.event === 'icpLaunched') {
                //This is good place to stop loader
                console.log('Citrus ICP pop-up is launched');
            } else if (cbObj.event === 'icpClosed') {
                console.log(JSON.stringify(cbObj.message));
                console.log('Citrus ICP pop-up is closed');
            }
        }
    });
});
</script>

<style>
form#walletUrl input {
    width: 400px;
}
</style>

<?php include('footer.php'); ?>
