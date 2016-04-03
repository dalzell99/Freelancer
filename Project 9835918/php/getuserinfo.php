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
            
        $response = array($showNames, $expenseTypes);
    } else {
        $response = 'Expense Types select query failed';
    }
} else {
    $response = 'Show Names select query failed';
}

echo json_encode($response);

mysqli_close($con);
?>