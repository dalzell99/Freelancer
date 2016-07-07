<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$email = $_POST['email'];
$numRejected = $_POST['numRejected'];

$sql = "UPDATE Users SET lockStart = '2016-01-01T00:00:00+00:00' WHERE username = '$username'";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';

    sendEmail(array($email), $databasephpQuizMasterEmail, "Your account has been unlocked",
    "<html>
        <body>
            <p>
                Dear " . $username . "
            </p>
            <p>
                Your quizmaster account has been unlocked. You can now start scheduling quizzes again.
            </p>
            <p>
                Regards<br />
                IQzeto Quizmaster
            </p>
        </body>
    </html>");
} else {
    echo 'fail' . $sql;
}

mysqli_close($con);
?>
