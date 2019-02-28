<!--The following function should only be used when the user wants to create an account.-->

<?php

function check() {
	
	return false;
}


function accountCheck($value) {
	include 'server.php';
	$sql = "SELECT username FROM account WHERE username='$value';";
	echo $conn->query($sql);
	
	
	return false;
}


function hashuser() {
	
}


function register() {
	// Always include this file in order to connect to database
	include 'server.php';
	
	// Get required variables;
	// Determine Account ID
	$accountID = 1;
	$username = mysqli_real_escape_string($conn, $_REQUEST['email']);
	$displayname = mysqli_real_escape_string($conn, $_REQUEST['dName']);
	$Fname = mysqli_real_escape_string($conn, $_REQUEST['fName']);
	$Lname = mysqli_real_escape_string($conn, $_REQUEST['lName']);
	$secquestion = mysqli_real_escape_string($conn, $_REQUEST['secQuestion']);
	$secanswer = mysqli_real_escape_string($conn, $_REQUEST['secAnswer']);

	//Check if account exist
	if (accountCheck($username)) {
		echo "Account already exist!";
		return;
	}
	// Error checking
	if (check()) {
		
		echo "Account creation failed!";
		return;
	}

	// Insert into
	$sql = "INSERT INTO account VALUES ('$accountID', '$username', '$displayname', '$Fname', '$Lname', '$secquestion', '$secanswer');";
	//echo $sql;	
	$conn->query($sql);
	// Always close the connection
	$conn->close();
	
	echo "Your account has been created!";
}
?>
