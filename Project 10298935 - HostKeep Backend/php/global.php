<?php
$dbusername = 'stephfl5_chris';
$dbpassword = 'du6R*Fb@x4c8mZT';
$dbname = 'stephfl5_hostkeepbackend';
$salt = 'kjG$^$^$#DHGvfl;/Gdp[]p/[;sH&^Z*TF/[lDGdbd98l;/;7y54ab987.[;[p.":."]';
$noReplyEmail = 'noreply@hostkeep.com.au';
$hostkeepEmail = 'hello@hostkeep.com.au';
$webAdminEmail = 'dalzell99@hotmail.com';

function hashPassword($con, $password) {
    return sha1(md5(mysqli_real_escape_string($con, $password) . $salt));
}
?>
