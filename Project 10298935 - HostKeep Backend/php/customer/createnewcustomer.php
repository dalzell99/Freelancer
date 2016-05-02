<?php
require('../global.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mt_rand(1000000, 9999999); // Create random 7 digit password

$sql = "INSERT INTO Customer(username, password, propertyIDs) VALUES ('$email', '" . hashPassword($con, $password) . "', '[]')";

// Insert new customer
if ($result = mysqli_query($con, $sql)) {
    $message = "
    <p>
        <h1>Welcome to HostKeep!</h1>
    </p>

    <p>
        <strong>Welcome to HostKeep Property Management</strong>
    </p>

    <p>
        The Hostkeep owners portal helps you update your personal and property details, and access your owner reporting.
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
                Add or make changes to your contact details
            </li>
            <li>
                Change your password
            </li>
            <li>
                Access monthly property reports
            </li>
        </ul>
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

    // Send welcome email with login details
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