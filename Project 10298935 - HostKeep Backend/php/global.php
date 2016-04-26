<?php
$dbusername = 'ccrsc638_test';
$dbpassword = 'freelancer9808082';
$dbname = 'ccrsc638_10298935';
$salt = 'kjG$^$^$#DHGvfl;/Gdp[]p/[;sH&^Z*TF/[lDGdbd98l;/;7y54ab987.[;[p.":."]';

function hashPassword($con, $password) {
    return sha1(md5(mysqli_real_escape_string($con, $password) . $salt));
}
?>
