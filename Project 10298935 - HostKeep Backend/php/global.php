<?php
$dbusername = 'ccrsc638_test';
$dbpassword = 'freelancer9808082';
$dbname = 'ccrsc638_10298935';
$salt = 'kjG$^$^$#DHGvfl;/Gdp[]p/[;sH&^Z*TF/[lDGdbd98l;/;7y54ab987.[;[p.":."]';
$noReplyEmail = 'noreply@hostkeep.com.au';
$hostkeepEmail = 'hello@hostkeep.com.au';
$webAdminEmail = 'dalzell99@hotmail.com';
$dashboardWebaddress = 'http://owners.hostkeep.com.au';
$hostkeepPhoneNumber = ''; //TODO: Add phone number

function hashPassword($con, $password) {
    return sha1(md5(mysqli_real_escape_string($con, $password) . $salt));
}
?>
