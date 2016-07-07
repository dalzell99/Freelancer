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

$sql = "UPDATE Users SET lockStart = '" . date('c') . "' WHERE username = '$username'";
if ($result = mysqli_query($con, $sql)) {
    echo 'success';

    sendEmail(array($email), $databasephpQuizMasterEmail, "Your account has been locked",
    "<html>
        <body>
            <p>
                Dear " . $username . "
            </p>
            <p>
                Your quizmaster account has been locked because we have noticed that you have had " . $numRejected . " rejected questions for your account. Kindly ensure to verify each question along with its correct answer before submission. Your account will be unlocked after 24 hrs. To avoid any future locking kindly ensure you comply with our quizmaster rules and regulation mentioned in our terms and condition page.
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
