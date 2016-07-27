<?php
require('../database.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$resultEmail = mysqli_query($con, "SELECT username FROM Users WHERE email = '" . mysqli_real_escape_string($con, $_POST['username']) . "'");

if (mysqli_num_rows($resultEmail) > 0) {
    $username = mysqli_fetch_assoc($resultEmail)['username'];
} else {
    $username = mysqli_real_escape_string($con, $_POST['username']);
}
$password = md5(md5($_POST['password'] . strtolower($username)) . $salt);

$sql = "SELECT password, loggedInToday, loggedIn FROM Users WHERE username = '$username' OR email = '$username'";

if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (time() - strtotime($row['loggedIn']) < 10) {
            echo json_encode(array('loggedIn', ''));
        } else if ($row['password'] == $password) {
            if ($row['loggedInToday'] == 'n') {
                $sql3 = "UPDATE Users SET loggedInToday = 'y', freeUnconvertablePointsBalance = freeUnconvertablePointsBalance + 20 WHERE username = '$username'";
                mysqli_query($con, $sql3);
            }

            $sql4 = "UPDATE Users SET loggedIn = 'y' WHERE username = '$username'";
            mysqli_query($con, $sql4);

            $sql2 = "SELECT userID, username, paidPointsBalance, freeConvertablePointsBalance, freeUnconvertablePointsBalance, email, emailConfirmed, notificationsArray, timeNotificationsViewed, numQuizzesTakenRemaining, quizMaster FROM Users WHERE username = '$username'";
            if ($result2 = mysqli_query($con, $sql2)) {
                $row2 = mysqli_fetch_assoc($result2);
                echo json_encode(array('correct', $row2));
            }
        } else {
            echo json_encode(array('incorrect', ''));
        }
    } else {
        echo json_encode(array('usernamedoesntexist', ""));
    }
} else {
    echo json_encode(array('fail', $sql));
}

mysqli_close($con);
?>
