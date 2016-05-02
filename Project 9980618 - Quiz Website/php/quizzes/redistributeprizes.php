<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sqlDistribution = "SELECT * FROM Distribution";
$resultDistribution = mysqli_query($con, $sqlDistribution);
$percentages = mysqli_fetch_assoc($resultDistribution);

$sqlQuizzes = "SELECT * FROM Quizzes WHERE checked = 'n' AND type = 'paid'";
$resultQuizzes = mysqli_query($con, $sqlQuizzes);
$quizzes = mysqli_fetch_assoc($resultQuizzes);

foreach ($quizzes as $quiz) {
    // Check if there is less than 10 minutes to start of quiz
    $startTime = strtotime($quiz['startTime']);
    $now = time();

    if ($quizEndTime - $now < 600) {
        // If quiz starts within 10 minutes (600 seconds) then check if $minRegisteredUsers or more users registered
        if (count($quiz['userRegistered']) >= $minRegisteredUsers) {
            // If 10 or more registered then distribute prizes based on above percentages
            $totalRegistrationFees = count($quiz['userRegistered']) * $quiz['pointsCost'];
            $rewards = json_encode(array(
                $totalRegistrationFees * ($percentages['first'] / 100),
                $totalRegistrationFees * ($percentages['second'] / 100),
                $totalRegistrationFees * ($percentages['third'] / 100)
            ));

            mysqli_query($con, "UPDATE Quizzes SET checked = 'y' WHERE quizID = " . $quiz['quizID']);
        } else {
            // If less than 10 registered, refund registered users plus 1 bonus quizeto and cancel quiz and send them an email
            foreach ($quiz['userRegistered'] as $userID) {
                mysqli_query($con, "UPDATE Users SET paidPointsBalance = paidPointsBalance + 1 + " . $quiz['pointsCost'] . " WHERE userID = '$userID'");
                $resultUser = mysqli_query($con, "SELECT email FROM Users WHERE userID = '$userID'");
                sendEmail(mysqli_fetch_assoc($resultUser)['email'], $databasephpInfoEmail, "Cancelled Quiz",
                "<html>
                    <body>
                        <p>
                            A quiz you registered for has been cancelled because less than 10 people registered for it. You have been refunded your fee and as a way of saying sorry, we have have given you an extra real quizeto.
                        </p>
                    </body>
                </html>
                ");
            }

            mysqli_query($con, "DELETE FROM Quizzes WHERE quizID = " . $quiz['quizID']);
        }
    }
}

mysqli_close($con);
?>
