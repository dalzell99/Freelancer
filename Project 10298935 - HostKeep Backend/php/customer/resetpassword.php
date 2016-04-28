<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mt_rand(1000000, 9999999); // Create random 7 digit password

$sql = "SELECT * FROM Customer WHERE username = '$username'";
$sql1 = "UPDATE Customer SET password = '" . hashPassword($con, $password) . "' WHERE username = '$username'";

// Check if a user exists for provided username
if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        // If username exists then update customer record and send temp password in email
        if (mysqli_query($con, $sql1)) {
            $message = "
            <p>
                You can either click the link below or copy and paste it into the address bar of your browser. You will be prompted to change your password.
            </p>

            <p>
                <a href='$dashboardWebaddress/reset-password.php?username=$username&password=$password'>$dashboardWebaddress/reset-password.php?username=$username&password=$password</a>
            </p>

            <p>
                If you have any questions about your account or any other matter, please contact us at <a href='$hostkeepEmail'>$hostkeepEmail</a>
            </p>

            <p>
                Cheers,
            </p>

            <p>
                Alana, Stephen & Daniel
            </p>

            <p style='color: #00b7a6; font-weight: bold;'>
                HostKeep Team
            </p>
            ";

            if (sendEmail($username, $noReplyEmail, 'Reset HostKeep Password', $message)) {
                echo 'success';
            } else {
                sendErrorEmail("
                resetpassword.php<br />
                Email Fail
                ");
                echo 'failmail';
            }
        } else {
            sendErrorEmail("
            resetpassword.php<br />
            sql: $sql1
            ");
            echo "fail";
        }
    } else {
        echo 'doesntexist';
    }
} else {
    sendErrorEmail("
    resetpassword.php<br />
    sql: $sql
    ");
    echo 'failselectsql';
}

mysqli_close($con);
?>
