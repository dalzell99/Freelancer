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

    $sql2 = "SELECT * FROM QuizResults WHERE username = '$username'";
    if ($resultResults = mysqli_query($con, $sql2)) {
        $quizResults = [];
        while ($rowResults = mysqli_fetch_assoc($resultResults)) {
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

                echo json_encode(array('success', $response));
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
