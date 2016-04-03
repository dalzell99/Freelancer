<?php
$config = parse_ini_file('/home/ccrsc638/config9835918.ini'); 

// Try and connect to the database
$con = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

$response = '';

// Check connection
if (mysqli_connect_errno()) {
    $response = "Failed to connect to MySQL: " . mysqli_connect_error();
}

if ($result1 = mysqli_query($con, "SELECT * FROM ShowNames ORDER BY `showName` ASC")) {
    
    /* fetch associative array */
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $showNames[] = $row1;
    }
    
    if ($result2 = mysqli_query($con, "SELECT * FROM ExpenseTypes ORDER BY `expenseType` ASC")) {
    
        /* fetch associative array */
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $expenseTypes[] = $row2;
        }
        
        if ($result3 = mysqli_query($con, "SELECT username, accountType, expenses FROM Users")) {
            /* fetch associative array */
            while ($row3 = mysqli_fetch_assoc($result3)) {
                $users[] = $row3;
            }
            
            if ($result4 = mysqli_query($con, "SELECT * FROM Expenses")) {
                /* fetch associative array */
                while ($row4 = mysqli_fetch_assoc($result4)) {
                    $expenses[] = $row4;
                }
            
                $response = array($showNames, $expenseTypes, $users, $expenses);
            } else {
                $response = 'Expenses select query failed';
            }
        } else {
            $response = 'Users select query failed';
        }
    } else {
        $response = 'Expense Types select query failed';
    }
} else {
    $response = 'Show Names select query failed';
}

echo json_encode($response);

mysqli_close($con);
?>