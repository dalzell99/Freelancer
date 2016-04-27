<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mt_rand(1000000, 9999999);

if ($result = mysqli_query($con, "INSERT INTO Customer(username, password, propertyIDs) VALUES ('$email', '" . hashPassword($con, $password) . "', '[]')")) {
    $message = "
    <p>
        <strong>Hi, welcome to HostKeep</strong>
    </p>

    <p>
        Bentham IMF Limited's Online Client Access tool, PORTAL, has been designed to keep you up to date with your IMF participation.
    </p>

    <p>
        You can always login at <a href='https://www.imf.com.au/portal'>https://www.imf.com.au/portal</a> using the details below.
    </p>

    <table style='width: 90%; background-color: #e4e4e4'>
        <tr>
            <td style='width: 20%; font-weight: bold;'>
                Link
            </td>
            <td>
                <a href='https://www.imf.com.au/portal'>https://www.imf.com.au/portal</a>
            </td>
        </tr>
        <tr>
            <td style='width: 20%; font-weight: bold;'>
                Login
            </td>
            <td>
                $email
            </td>
        </tr>
        <tr>
            <td style='width: 20%; font-weight: bold;'>
                Password
            </td>
            <td>
                $password
            </td>
        </tr>
    </table>

    <p>
        You will be prompted to change your password and confirm your contact details at your first login.
    </p>

    <p>
        When in your profile, you will be able to do the following:
        <ul>
            <li>
                Make changes to your contact details
            </li>
            <li>
                Change your password
            </li>
            <li>
                Access recent documents and important information that is sent to you.
            </li>
        </ul>
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

    if (sendEmail($email, 'noreply@hostkeep.com.au', 'Welcome to HostKeep', $message)) {
        echo 'success';
    } else {
        echo 'failmail';
    }
} else {
    echo "failsql INSERT INTO Customer(username, password) VALUES ('$email', '" . hashPassword($password) . "')";
}

mysqli_close($con);
?>
