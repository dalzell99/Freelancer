<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mt_rand(1000000, 9999999);

if ($result = mysqli_query($con, "SELECT * FROM Customer WHERE username = '$username'")) {
    if (mysqli_num_rows($result) > 0) {
        if (mysqli_query($con, "UPDATE Customer SET password = '" . hashPassword($con, $password) . "' WHERE username = '$username'")) {
            $message = "
            <p>
                <strong>Hi, welcome to HostKeep</strong>
            </p>

            <p>
                Either click the link below or copy and paste it into the address bar of your browser. You will be prompted to change your password.
            </p>

            <p>
                <a href='http://ccrscoring.co.nz/10298935/reset-password.php?username=$username&password=$password'>http://ccrscoring.co.nz/10298935/reset-password.php?username=$username&password=$password</a>
            </p>

            <p>
                If you have any questions about your PORTAL account or any other matter, please contact us at <a href='mailto:portal@imf.com.au'>portal@imf.com.au</a> or by phone on 08 9225 2322 or Freecall 1800 016 464
            </p>

            <p>
                <strong>If this email was sent to you in error, please call IMF on 1800 016 464</strong>
            </p>

            <p>
                Regards,
            </p>

            <p style='color: #5cd65c; font-weight: bold;'>
                Client Liaison Team
            </p>
            ";

            if (sendEmail($username, 'noreply@hostkeep.com.au', 'Reset HostKeep Password', $message)) {
                echo 'success';
            } else {
                echo 'failmail';
            }
        } else {
            echo "failsql INSERT INTO Customer(username, password) VALUES ('$username', '" . hashPassword($password) . "')";
        }
    } else {
        echo 'doesntexist';
    }
} else {
    echo 'failselectsql';
}

mysqli_close($con);
?>
