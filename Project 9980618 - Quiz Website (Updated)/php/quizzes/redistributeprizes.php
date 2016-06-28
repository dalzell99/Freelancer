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
while ($quiz = mysqli_fetch_assoc($resultQuizzes)) {
    // Check if there is less than 2 minutes to start of quiz
    $startTime = strtotime($quiz['startTime']);
    $now = time();

    if ($startTime - $now < 120) {
        // If quiz starts within 2 minutes (120 seconds) then check if 10 or more users registered
        if (count(json_decode($quiz['userRegistered'])) >= $quiz['minPlayers']) {
            // If 10 or more registered then distribute prizes based on above percentages
            $totalRegistrationFees = count(json_decode($quiz['userRegistered'])) * $quiz['pointsCost'];
            $rewards = json_encode(array(
                $totalRegistrationFees * ($percentages['first'] / 100),
                $totalRegistrationFees * ($percentages['second'] / 100),
                $totalRegistrationFees * ($percentages['third'] / 100)
            ));

            echo $rewards;

            mysqli_query($con, "UPDATE Quizzes SET checked = 'y', pointsRewards = '$rewards' WHERE quizID = " . $quiz['quizID']);
        } else {
            // If less than minPlayers registered, refund registered users plus 1 bonus quizeto and cancel quiz and send them an email
            foreach (json_decode($quiz['userRegistered']) as $userID) {
                // Refund fee to user plus 1 extra bonus quizeto (	freeConvertablePointsBalance)
                mysqli_query($con, "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $quiz['pointsCost'] . ", 	freeConvertablePointsBalance = 	freeConvertablePointsBalance + 1 WHERE userID = '$userID'");
                $resultUser = mysqli_query($con, "SELECT email FROM Users WHERE userID = '$userID'");
                sendEmail(array(mysqli_fetch_assoc($resultUser)['email']), $databasephpInfoEmail, "Cancelled Quiz",
                "<html>
                    <body>
                        <p>
                            A quiz you registered for has been cancelled because less than 10 people registered for it. You have been refunded your fee and as a way of saying sorry, we have have given you an extra real quizeto.
                        </p>
                    </body>
                </html>
                ");
            }

            mysqli_query($con, "UPDATE Quizzes SET checked = 'y', cancelled = 'y' WHERE quizID = " . $quiz['quizID']);

            // Add questions back into database
            foreach ($quiz['questions'] as $question) {
                $question = $question[0];
                $answers = $question[1];
                $correctAnswer = $question[2];
                $creator = $question[3];
                $category = 'Miscellaneous';

                $sqlQuestion = "INSERT INTO Questions VALUES (DEFAULT, '$question', '$answers', '$correctAnswer', '$category', '$creator')";
                mysqli_query($con, $sqlQuestion);
            }

            // Send email to creator of quiz
            $resultCreator = mysqli_query($con, "SELECT email FROM Users WHERE username = '" . $quiz['creatorUsername'] . "'");
            sendEmail(array(mysqli_fetch_assoc($resultCreator)['email']), $databasephpInfoEmail, "Cancelled Quiz",
            "<html>
                <body>
                    <p>
                        Dear " . $quiz['creatorUsername'] . "
                    </p>
                    <p>
                        Your scheduled quiz has been cancelled as your submitted question did not pass our screening criteria. Please try submitting different question to schedule the quiz again
                    </p>
                    <p>
                        Regards,
                        IQzeto Quizmaster
                    </p>


                </body>
            </html>
            ");
        }
    }
}

mysqli_close($con);
?>
