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

$sql = "INSERT INTO Customer(username, password, propertyIDs) VALUES ('$email', '" . hashPassword($con, $password) . "', '[]')";

if ($result = mysqli_query($con, $sql)) {
    $message = "
    <p>
        <strong>Hi, welcome to HostKeep</strong>
    </p>

    <p>
        Hostkeep's Online Client Access tool has been designed to keep you up to date with your Hostkeep participation.
    </p>

    <p>
        You can always login at <a href='$dashboardWebaddress'>$dashboardWebaddress</a> using the details below.
    </p>

    <table style='width: 90%; background-color: #e4e4e4'>
        <tr>
            <td style='width: 20%; font-weight: bold;'>
                Link
            </td>
            <td>
                <a href='$dashboardWebaddress'>$dashboardWebaddress</a>
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
        If you have any questions about your account or any other matter, please contact us at <a href='$hostkeepEmail'>$hostkeepEmail</a>
    </p>

    <p>
        <strong>If this email was sent to you in error, please call HostKeep on $hostkeepPhoneNumber</strong>
    </p>

    <p>
        Regards,
    </p>

    <p style='color: #5cd65c; font-weight: bold;'>
        Client Liaison Team
    </p>
    ";

    if (sendEmail($email, $noReplyEmail, 'Welcome to HostKeep', $message)) {
        echo 'success';
    } else {
        sendErrorEmail("
        createnewcustomer.php<br />
        Mail Fail
        ");
        echo 'failmail';
    }
} else {
    sendErrorEmail("
    createnewcustomer.php<br />
    sql: $sql
    ");
    echo "fail";
}

mysqli_close($con);
?>
