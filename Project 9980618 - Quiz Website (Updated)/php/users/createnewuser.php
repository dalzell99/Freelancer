<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = md5(md5($_POST['password'] . strtolower($username)) . $salt);
$email = mysqli_real_escape_string($con, $_POST['email']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
$emailCode = $_POST['emailCode'];
$sql = "INSERT INTO Users (userID, username, password, paidPointsBalance, freeConvertablePointsBalance,  freeUnconvertablePointsBalance, email, emailConfirmed, securityQuestions, notificationsArray, loggedInToday, mobile, submittedQuestionID, purchasedQuizzesRemaining, approvedQuestionCount, rejectedQuestions, numQuizzesTakenRemaining, quizMaster, numQuizzesPurchased, numQuizzesScheduledUser, numQuizzesScheduledQuizMaster, numQuizzesTaken) VALUES (DEFAULT, '$username', '$password', 0, 0, 20, '$email', '$emailCode', '[]', '[]', 'y', '$mobile', '[]', 0, 0, '[]', 0, 'n', 0, 0, 0, 0)";

$to = array($email);
$from = $databasephpNoReplyEmail;
$subject = "Welcome to IQzeto";
$message = "
<html>
    <body>
        <img id='logo' src='https://www.iqzeto.com/images/logo3.png' alt=''>

        <p><b>Greetings $username,</b></p>

        <p>Welcome to IQzeto.com, the world's best online quizzing platform</p>

        <p><a href='https://www.iqzeto.com/emailverification.php?email=$email&code=$emailCode'>Click here to verify your email address</a></p>

        <p>IQzeto.com offers online trivia game show which is completely challenging and guarantees 24 hours entertainment with knowledge add-on from various fields. This is an online platform where brains across the globe come together and compete with each other's IQ & intelligence for millions of cash rewards at stake.</p>

        <p>You have the option to take both free as well as paid quizzes which are scheduled 24/7 on the platform. We strive to make your online quiz experience best across the world. Practice your knowledge skills in free quizzes and once you are confident, dare the intelligent minds across the globe in paid quizzes to win millions of cash rewards.</p>

        <p>
        <strong>Our Vision</strong>
        </p>

        <p>Here at IQzeto.com we consider our Social Responsibility important. We adore doing great for our kindred man and offering back to the group that made us. We empower everyone with the capacity to develop their intelligence and IQ in an entertaining and rewarding way.</p>

        <p>
        <strong>Our Mission</strong>
        </p>

        <p>Our core mission is to innovate and build a platform to spread knowledge & develop IQ in an entertaining and rewarding way that reaches to the society.</p>

        <p>
        <strong>What we offer</strong>
        </p>

        <p>We at IQzeto.com empower life learning and follow the principle of 'earning while learning'. We do this with Quiz Alerts with an end goal to test information about different subjects at the same time helping everyone to become monetarily independent. We pride ourselves on being family-accommodating and empower friendly rivalry by means of our Leader board.</p>

        <p>
        We believe in building knowledge and developing IQ in an entertaining and rewarding way
        </p>

        <p>IQzeto provides unlimited quizzes with cash rewards every minute, making it the preferred quiz platform for everyone.</p>

        <p>
        Wish you all the very best and happy quizzing...
        </p>

        <p><b>Regards</b></p>

        <p><b>Team IQzeto</b> </p>

        <style>
            #logo {
                height: 100px;
                display: block;
                margin: 0 auto;
            }
        </style>

    </body>
</html>
";

$sqlUsername = "SELECT userID FROM Users WHERE username = '$username' OR email = '$email'";

if ($result = mysqli_query($con, $sqlUsername)) {
    if (mysqli_num_rows($result) > 0) {
        echo 'exists';
    } else {
        if (mysqli_query($con, $sql)) {
            $sendEmailResult = sendEmail($to, $from, $subject, $message);
            if ($sendEmailResult == 'success') {
                echo 'success';
            } else {
                mysqli_query($con, "DELETE FROM Users WHERE username = '$username'");
                echo 'Verication email unable to be sent. Please try signing up again later.';
            }
        } else {
            echo 'fail' . $sql;
        }
    }
} else {
    echo 'fail' . $sql;
}



mysqli_close($con);
?>
