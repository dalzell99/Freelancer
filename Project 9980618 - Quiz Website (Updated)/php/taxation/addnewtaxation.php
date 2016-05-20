<?php
function addNewTaxation($username, $grossQuizetos) {
    $con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $username = $_POST['username'];
    $grossQuizetos = $_POST['grossQuizetos'];
    $taxAmount = ceil($grossQuizetos * .309);
    $netQuizetos = $grossQuizetos - $taxAmount;

    $resultsUser = mysqli_query($con, "SELECT mobile, email FROM Users WHERE username = '$username'");
    $mobile = mysqli_fetch_assoc($resultsUser)['mobile'];
    $email = mysqli_fetch_assoc($resultsUser)['email'];

    $sql = "INSERT INTO Taxation VALUES (DEFAULT, '$username', '$mobile', '$email', '$grossQuizetos', '$taxAmount', '$netQuizetos')";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }

    mysqli_close($con);
}
?>
