<!--The following function should only be used when the user wants to create an account.-->

<?php

// Always include this file in order to connect to database
include 'server.php';

// Needed variables;
$accountID = 1;
$username = 'admin';
$displayname = 'test';
$Fname = 'test';
$Lname = 'test';
$secquestion = 1;
$secanswer = 'test';

//Check if account exist

// Insert into
$sql = "INSERT INTO account VALUES ('$accountID', '$username', '$displayname', '$Fname', '$Lname', '$secquestion', '$secanswer');";


//echo $sql;	

$conn->query($sql);

// Always close the connection
$conn->close();
?> 
