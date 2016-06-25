<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];

$response = [];

$sql1 = "SELECT * FROM Users WHERE username = '$username'";
if ($resultUsers = mysqli_query($con, $sql1)) {
    $quizUsers = [];
    while ($rowUsers = mysqli_fetch_assoc($resultUsers)) {
        $quizUsers[] = $rowUsers;
    }
    array_push($response, $quizUsers);

    // Get all quiz results for this user
    $sql2 = "SELECT * FROM QuizResults WHERE username = '$username'";
    if ($resultResults = mysqli_query($con, $sql2)) {
        $quizResults = [];
        while ($rowResults = mysqli_fetch_assoc($resultResults)) {
            // For each quiz result, get the quiz fee and name (category)
            $sqlQuizzes = "SELECT category, pointsCost FROM Quizzes WHERE quizID = '" . $rowResults['quizID'] . "'";
            $resultQuizzes = mysqli_query($con, $sqlQuizzes);
            $rowQuizzes = mysqli_fetch_assoc($resultQuizzes);
            $rowResults['fee'] = $rowQuizzes['pointsCost'];
            $rowResults['name'] = $rowQuizzes['category'];

            $quizResults[] = $rowResults;
        }
        array_push($response, $quizResults);

        $sql3 = "SELECT * FROM Withdrawal WHERE username = '$username'";
        if ($resultWithdrawal = mysqli_query($con, $sql3)) {
            $quizWithdrawal = [];
            while ($rowWithdrawal = mysqli_fetch_assoc($resultWithdrawal)) {
                $quizWithdrawal[] = $rowWithdrawal;
            }
            array_push($response, $quizWithdrawal);

            $sql4 = "SELECT * FROM Purchases WHERE username = '$username'";
            if ($resultPurchases = mysqli_query($con, $sql4)) {
                $quizPurchases = [];
                while ($rowPurchases = mysqli_fetch_assoc($resultPurchases)) {
                    $quizPurchases[] = $rowPurchases;
                }
                array_push($response, $quizPurchases);

                $sql5 = "SELECT * FROM Taxation WHERE username = '$username'";
                if ($resultTaxation = mysqli_query($con, $sql5)) {
                    $quizTaxation = [];
                    while ($rowTaxation = mysqli_fetch_assoc($resultTaxation)) {
                        $quizTaxation[] = $rowTaxation;
                    }
                    array_push($response, $quizTaxation);

                    $sql6 = "SELECT numQuizzesTaken, numQuizzesScheduled, numQuizzesPurchased, approvedQuestionCount, rejectedQuestions FROM Users WHERE username = '$username'";
                    if ($resultQuizMaster = mysqli_query($con, $sql6)) {
                        $quizQuizMaster = [];
                        while ($rowQuizMaster = mysqli_fetch_assoc($resultQuizMaster)) {
                            $resultScheduleTarget = mysqli_query($con, "SELECT quizScheduleTarget FROM QuizMaster WHERE id=1");
                            $rowQuizMaster['quizScheduleTarget'] = mysqli_fetch_assoc($resultScheduleTarget)['quizScheduleTarget'];

                            $quizzes = [];
                            $resultScheduledQuizzes = mysqli_query($con, "SELECT category, startTime, userRegistered, winningUserID, creatorEarnings, pointsCost FROM Quizzes WHERE creatorUsername = '$username'");
                            while ($rowScheduledQuizzes = mysqli_fetch_assoc($resultScheduledQuizzes)) {
                                $resultQuizWinner = mysqli_query($con, "SELECT username FROM Users WHERE userID = " . $rowScheduledQuizzes['winningUserID']);
                                $rowScheduledQuizzes['winner'] = mysqli_fetch_assoc($resultQuizWinner)['username'];

                                $quizzes[] = $rowScheduledQuizzes;
                            }

                            $rowQuizMaster['previouslyScheduledQuizzes'] = $quizzes;

                            $quizQuizMaster[] = $rowQuizMaster;
                        }
                        array_push($response, $quizQuizMaster);

                        echo json_encode(array('success', $response));
                    } else {
                        echo 'fail QuizMaster' . $sql6;
                    }
                } else {
                    echo 'fail Taxation' . $sql5;
                }
            } else {
                echo 'fail Purchases' . $sql4;
            }
        } else {
            echo 'fail Withdrawal' . $sql3;
        }
    } else {
        echo 'fail quizresults' . $sql2;
    }
} else {
    echo 'fail Users' . $sql1;
}

mysqli_close($con);
?>
