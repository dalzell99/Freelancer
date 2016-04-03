<?php
require('databasedetails.php');
$con = mysqli_connect('localhost', $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result = mysqli_query($con, "SELECT * FROM Users")) {
    $currentTimeString = date("Y-m-d H:i:s");
    $usersPossibly = array();
    $usersNo = array();
    
    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        $available = $row['available'];
        $lastTimeLoggedIn = $row['lastTimeLoggedIn'];
        $username = $row['username'];
        
        $timeDiffInMinutes = round((strtotime($currentTimeString) - strtotime($lastTimeLoggedIn)) / 60, 0);
        
        if ($timeDiffInMinutes >= 30 && $timeDiffInMinutes < 60 && $available == 'y') {
            array_push($usersPossibly, $username);
        } else if ($timeDiffInMinutes >= 60) {
            array_push($usersNo, $username);
        }
    }
    
    $changedCount = 0;
    for ($k = 0; $k < count($usersPossibly); $k++) {
        $update = " UPDATE Users SET available = 'p' WHERE username = '" . $usersPossibly[$k] . "' ";
        if (mysqli_query($con, $update)) {
            $changedCount++;
        } else {
            echo 'fail' . $update;
        }
    }
    
    for ($l = 0; $l < count($usersNo); $l++) {
        $update = " UPDATE Users SET available = 'n' WHERE username = '" . $usersNo[$l] . "' ";
        if (mysqli_query($con, $update)) {
            $changedCount++;
        } else {
            echo 'fail' . $update;
        }
    }

    if ($changedCount == (count($usersPossibly) + count($usersNo))) {
        echo "success. " . $changedCount . " users changed.";
    }
    
    /* free result set */
    mysqli_free_result($result);
} else {
    echo 'fail';
}

mysqli_close($con);
?>