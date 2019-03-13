<!--The following function should only be used when the user wants to create an account.-->

<?php

function check() {
	if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_REQUEST['email'])) {
		echo "<span class='warning' id='warning'>Invalid Email Format!</span>";
		return true;
	}
	
	return false;
}


function unhash() {
	
}


function login() {
	// Always include this file in order to connect to database
	include 'server.php';
	//echo 'Logging in now';
	
	// Check for garbage
	if (check()) {
		return;
	}
	
	// Get variables
	$username = mysqli_real_escape_string($conn, $_REQUEST['email']);
	$password = mysqli_real_escape_string($conn, $_REQUEST['password']);
	
	// Unhash account
	unhash();
	
	// Get information.
	$sql = "SELECT accountID, displayname FROM account WHERE username='$username'";
	//echo $sql;	
	$result = $conn->query($sql);
	// Always close the connection
	$conn->close();
	
	if ($result->num_rows > 0) {
		// echo 'Account found';
		$row = $result->fetch_assoc();
		$_SESSION["accountID"] = $row['accountID'];
		$_SESSION["displayname"] = $row['displayname'];
		echo "<span class='warning' id='warning'>Welcome " .$_SESSION['displayname'] . "! Redirecting you to the home page.</span>";
		echo "<meta http-equiv='refresh' content='4;url=http://webapp.cs.clemson.edu/~boferre/metube/index.php' />";
		
		
	} else {
		echo "<span class='warning' id='warning'>Could not find the given account!</span>";
	}
	
	
}

?>