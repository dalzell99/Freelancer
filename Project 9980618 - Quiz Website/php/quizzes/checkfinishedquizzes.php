<?php
require('../database.php');
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
    // Get the userID of the users who will receive prizes ordered by percent correct then time taken
    $sqlResults = "SELECT userID FROM QuizResults WHERE quizID = '" . $quiz['quizID'] . "' 
    ORDER BY correctPercent DESC, timeTaken ASC";

    if ($resultResults = mysqli_query($con, $sqlResults)) {
        while ($rowResults = mysqli_fetch_assoc($resultResults)) {
            if ($userRank < count($prizes)) {
                // Add prize to users paid points balance
                $sqlUserUpdated = "UPDATE Users SET paidPointsBalance = paidPointsBalance + " . $prizes[$userRank] . " WHERE userID = '" . $rowResults['userID'] . "'";
                if ($userRank == 0) {
                    $winningUserID = $rowResults['userID'];
                }
                
                if (!mysqli_query($con, $sqlUserUpdated)) {
                    echo 'fail3. ' . $sqlUserUpdated;
                }
                
                $prizeMessage = "Congratulations, you won " . $prizes[$userRank] . " Real Quizetos which have been added to your account.";
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
            
            // Send prize winner an email
            $rowUser = mysqli_fetch_assoc($resultUser);
            $to = $rowUser['email'];
            $from = 'prizes@ccrscoring.co.nz';
            $subject = "You won a prize on Quizetos.com";
            $message = "
            <html>
                <body>
                    <p>Dear " . $rowUser['username'] . ",<br>You were ranked " . ($userRank + 1) . " in the " . $quiz['category'] . " quiz. " . $prizeMessage . "</p>
                    <p>Thanks & Regards,<br>Team Quizetos.com</p>
                </body>
            </html>
            ";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= "From: " . $from . "\r\n";
            
            if (!mail($to, $subject, $message, $headers)) {
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
        echo 'fail5. ' . $sqlQuizPaidOut;
    }
}

mysqli_close($con);
?>