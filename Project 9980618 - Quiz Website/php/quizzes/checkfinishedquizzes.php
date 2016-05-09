<?php
require('../database.php');
require('../sendemail.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sqlQuiz = "SELECT * FROM Quizzes WHERE type = 'paid'";
$now = time();
$quizArray = [];

// Get all paid quizzes
if ($resultQuiz = mysqli_query($con, $sqlQuiz)) {

    while ($rowQuiz = mysqli_fetch_assoc($resultQuiz)) {
        $quizEndTime = strtotime($rowQuiz['endTime']);
        if ($now - $quizEndTime > 300 && $rowQuiz['paidOut'] == 'n') { // If the quiz finished more than 5 minutes ago and hasn't been paid out then add to quiz to $quizArray
            $quizArray[] = $rowQuiz;
        }
    }
} else {
    echo 'fail1. ' . $sqlQuiz;
}

// For each quiz that ended more than 5 minutes ago
foreach ($quizArray as $quiz) {
    // Get the prize list
    $prizes = json_decode($quiz['pointsRewards']);
    $userRank = 0;
    $winningUserID = -1;
    // Get the userID of the users who will receive prizes ordered by percent correct then time taken
    $sqlResults = "SELECT userID, quizID FROM QuizResults WHERE quizID = '" . $quiz['quizID'] . "'
    ORDER BY correctPercent DESC, timeTaken ASC";

    if ($resultResults = mysqli_query($con, $sqlResults)) {
        while ($rowResults = mysqli_fetch_assoc($resultResults)) {
            if ($userRank < count($prizes)) {
                if ($prizes[$userRank] >= 10000) {
                    // Get User info for taxation element
                    $resultsUser = mysqli_query($con, "SELECT mobile, email, username FROM Users WHERE userID = '" . $rowResults['userID'] . "'");
                    $username = $_POST['username'];
                    $mobile = mysqli_fetch_assoc($resultsUser)['mobile'];
                    $email = mysqli_fetch_assoc($resultsUser)['email'];

                    // Calculate tax of 30.9% if value is above 9999
                    $grossQuizetos = $prizes[$userRank];
                    $taxAmount = ceil($grossQuizetos * .309);
                    $netQuizetos = $grossQuizetos - $taxAmount;

                    // Insert into taxation table
                    $sql7 = "INSERT INTO Taxation VALUES (DEFAULT, '$username', '$mobile', '$email', '$grossQuizetos', '$taxAmount', '$netQuizetos')";
                    if (mysqli_query($con, $sql7)) {
                        // do nothing
                    } else {
                        echo "fail7" . $sql7;
                    }
                } else {
                    $netQuizetos = $prizes[$userRank];
                }

                // Add prize to users paid points balance
                $sqlUserUpdated = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $netQuizetos . " WHERE userID = '" . $rowResults['userID'] . "'";
                if ($userRank == 0) {
                    $winningUserID = $rowResults['userID'];
                }

                if (!mysqli_query($con, $sqlUserUpdated)) {
                    echo 'fail3. ' . $sqlUserUpdated;
                }

                $prizeMessage = "Congratulations, you won " . $netQuizetos . " Real Quizetos which have been added to your account.";
            } else {
                $prizeMessage = "";
            }

            // Then retrieve the info for each prize winner
            $sqlUser = "SELECT * FROM Users WHERE userID = '" . $rowResults['userID'] . "'";
            if ($resultUser = mysqli_query($con, $sqlUser)) {
                // do nothing
            } else {
                echo 'fail4. ' . $sqlUser;
            }

            // Add users rank to their quiz result from this quiz
            $sqlRank = "UPDATE QuizResults SET userRank = '" . ($userRank + 1) . "' WHERE quizID = '" . $rowResults['quizID'] . "' AND userID = '" . $rowResults['userID'] . "'";
            if (mysqli_query($con, $sqlRank)) {
                // do nothing
            } else {
                echo 'fail5. ' . $sqlRank;
            }

            // Send prize winner an email
            $rowUser = mysqli_fetch_assoc($resultUser);
            $to = array($rowUser['email']);
            $from = $databasephpPrizeEmail;
            $subject = "You won a prize on Quizetos.com";
            $message = "
            <html>
                <body>
                    <p>Dear " . $rowUser['username'] . ",<br>You were ranked " . ($userRank + 1) . " in the " . $quiz['category'] . " quiz. " . $prizeMessage . "</p>

                    <div class='container'>
                        <img src='placehold.it/300' /><p>
                        <h1>Quizeto.com</h1><br>
                        <h4>congratulates</h4>
                        <h3>" . $rowUser['username'] . "</h3>
                        <h2>on finishing ranked<h2>
                        <h4>" . ($userRank + 1) . "</h4><br>
                        <h5>in the " . $quiz['category'] . " quiz.</h5>
                    </div>

                    <p>Thanks & Regards,<br>Team Quizetos.com</p>
                    <style>
                        .container{
                            border: 6px double black;
                            height: 544px;
                            box-sizing: border-box;
                            padding: 100px 20px 0;
                            font-family:san serif;
                            text-align:center;
                            font-weight:bold;
                            font-size: 2em;
                        }
                        h1,h2,h3,h4,h5{margin:0 0 0.25em}
                        body,html{padding:0;margin:0}
                    </style>
                </body>
            </html>
            ";

            $sendEmailResult = sendEmail($to, $from, $subject, $message);
            if ($sendEmailResult != 'success') {
                echo 'mailfail';
            }

            $userRank += 1;
        }
    } else {
        echo 'fail2. ' . $sqlResults;
    }

    // Mark quiz as paid out
    $sqlQuizPaidOut = "UPDATE Quizzes SET paidOut = 'y', winningUserID = '$winningUserID' WHERE quizID = '" . $quiz['quizID'] . "'";
    if (!mysqli_query($con, $sqlQuizPaidOut)) {
        echo 'fail6. ' . $sqlQuizPaidOut;
    }
}

mysqli_close($con);
?>
