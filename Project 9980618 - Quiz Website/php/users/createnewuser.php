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
$sql = "INSERT INTO Users VALUES (DEFAULT, '$username', '$password', 0, 0, 20, '$email', '$emailCode', '[]', '', '[]', '', 'y', '$mobile')";

$to = array($email);
$from = $databasephpNoReplyEmail;
$subject = "Welcome to Quizeto";
$message = "
<html>
    <body>
        <img id='logo' src='http://ccrscoring.co.nz/9980618/images/logo.png'>
    
        <p><b>Greetings $username,</b></p>

        <p><b>Welcome to Quizeto</b></p>

        <p><b>Thanks so much for joining us. You’re on your way to Hot Seat</b></p>
        
        <p><a href='http://quizeto.com/emailverification.php?email=$email&code=$emailCode'>Click here to verify your email address</a></p>

        <p>Every one of us always wanted to participate in ‘<i>Kaun Banega crorepati </i>’ and ‘<i>Who wants to be a millionaire’</i> the two most famous TV reality show from India and US. But very few of us would have made it to the Hot seat. We brings you an online platform where everyone will be on hot seat everyday making their dreams come true of becoming a crorepati or a millionaire</p>

        <p><br />
        </p>

        <p>Welcome to <a href='http://quizeto.com/'>Quizeto.com</a>, the best place for online quiz in the world. This is an online platform which enables users participate in quiz of several formats from different subjects/fields with other best minds across the globe. <a href='http://quizeto.com/'>Quizeto.com</a> is the place where brain across the globe comes together and competes with each other’s IQ for millions of cash reward at stake. User register for free on this platform and have option to take both free as well as paid quizzes which are scheduled 24/7 on our platform. we strive to make your online quiz experience the best across the world.</p>

        <p><br />
        </p>

        <p>We are a team which offers quiz games which are completely challenging and guarantee 24 hour entertainment with knowledge add on from various fields. Practice your knowledge across subject’s skills with free quiz and once you are ready challenge the best mind across the world. Our quizzes have been developed for all level of users from students of all classes, Students preparing for higher education like medical, engineering or MBA entrance, IAS aspirants, Housewives, and working professional from various fields by dedicated quiz specialists keeping in mind all facets of quiz. </p>

        <p><br />
        </p>

        <p>Our core mission is to innovate and develop a technology to spread knowledge, general awareness &amp; develop IQ in an entertaining and rewarding way that reaches to the society.</p>

        <p><br />
        </p>

        <p><b>So what are you waiting for, go and grab the Hot Seat...</b></p>

        <p><br />
        </p>

        <p><b>Regards</b></p>

        <p><b>Team Quizeto</b> </p>
        
        <div id='footer'>
            <img class='footerImages' src='http://quizeto.com/images/QUIZ.png'>
            <img class='footerImages' src='http://quizeto.com/images/howtoquizzes.png'>
            <img class='footerImages' src='http://quizeto.com/images/howtowincash.png'>
            <img class='footerImages' src='http://quizeto.com/images/FAQ.png'>
        </div>

        <style>
            p {
                color: #800000;
            }
            
            #logo {
                height: 100px;
                display: block;
                margin: 0 auto;
            }
            
            .footerImages {
                width: 11%;
                margin: 2%;
            }
            
            #footer {
                text-align: center;
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