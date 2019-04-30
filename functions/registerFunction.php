<!--The following function should only be used when the user wants to create an account.-->

<?php

function displayVar($varname) {
	$display = "";
	
	if ($varname == 1 && isset($_REQUEST['fName'])) {
		$display = $_REQUEST['fName'];
	} elseif ($varname == 2 && isset($_REQUEST['lName'])) {
		$display = $_REQUEST['lName'];
	} elseif ($varname == 3 && isset($_REQUEST['email'])) {
		$display = $_REQUEST['email'];
	} elseif ($varname == 4 && isset($_REQUEST['dName'])) {
		$display = $_REQUEST['dName'];
	} elseif ($varname == 5 && isset($_REQUEST['secAnswer'])) {
		$display = $_REQUEST['secAnswer'];
	}
	
	echo $display;
}


function check() {
	
	if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_REQUEST['email'])) {
		echo "<span class='warning' id='warning'>Invalid Email Format!</span>";
		return true;
	} else {
		if (stripos($_REQUEST['dName'], ';') != false or
			stripos($_REQUEST['dName'], ')') != false or
			stripos($_REQUEST['dName'], '/') != false or
			stripos($_REQUEST['dName'], '-') != false ) {
			
			echo "<span class='warning' id='warning'>Displayname cannot have: ;, ), /, - </span>";
			return true;
		}
		
		if (!preg_match("^[_a-z]$^", $_REQUEST['fName']) or !preg_match("^[a-z]$^", $_REQUEST['lName'])) {
			echo "<span class='warning' id='warning'>Your name should only contain characters!</span>";
			return true;
		}
		
		if (stripos($_REQUEST['secAnswer'], ';') != false or
			stripos($_REQUEST['secAnswer'], ')') != false or
			stripos($_REQUEST['secAnswer'], '/') != false or
			stripos($_REQUEST['secAnswer'], '-') != false) {
			
			echo "<span class='warning' id='warning'>Your security Answer cannot have: ;, ), /, - </span>";
			return true;
		}
		
		
		if (empty($_REQUEST['password'])) {
			echo "<span class='warning' id='warning'>Your password cannot be empty!</span>";
			return true;
		}
	}
	
	return false;
}


function accountCheck($value) {
	include 'server.php';
	
	$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
	
	$sql = "SELECT username FROM account WHERE username='$value';";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
			return true;
	}
	
	$sql = "SELECT username FROM account WHERE username LIKE '$email%';";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
			return true;
	}
	
	return false;
}


function hashuser($value) {
	$hashedVariable = md5($value);
	
	return $hashedVariable;
}


function register() {
	// Always include this file in order to connect to database
	include 'server.php';
	
	// Error checking
	if (check()) {
		return;
	}
	
	// Get required variables;
	// Determine Account ID
	$sql = "SELECT MAX(accountID) FROM account;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$accountID = $row['MAX(accountID)'] + 1;
	
	// Get other variables
	$email = mysqli_real_escape_string($conn, $_REQUEST['email']);
	$pass = mysqli_real_escape_string($conn, $_REQUEST['password']);
	$passconfim = mysqli_real_escape_string($conn, $_REQUEST['passwordComp']);
	
	if (strcmp($pass, $passconfim) == 0) {
		$username = $email.hashuser($pass);
	} else {
		echo "<span class='warning' id='warning'>Your password confirmation does not match!</span>";
		return;
	}
	
	$displayname = mysqli_real_escape_string($conn, $_REQUEST['dName']);
	$Fname = mysqli_real_escape_string($conn, $_REQUEST['fName']);
	$Lname = mysqli_real_escape_string($conn, $_REQUEST['lName']);
	$secquestion = mysqli_real_escape_string($conn, $_REQUEST['secQuestion']);
	$secanswer = mysqli_real_escape_string($conn, $_REQUEST['secAnswer']);
	
	//Check if account exist
	if (accountCheck($username)) {
		echo "<span class='warning' id='warning'>Account already exist!</span>";
		return;
	}

	// Insert into
	$sql = "INSERT INTO account VALUES ('$accountID', '$username', '$displayname', '$Fname', '$Lname', '$secquestion', '$secanswer');";
	//echo $sql;	
	$conn->query($sql);
	// Always close the connection
	$conn->close();
	
	echo "<span class='warning' id='warning'>Success! Your account has been created. We are redirecting you to the log in page. Welcome to MeTube!</span>";
	echo "<meta http-equiv='refresh' content='4;url=http://webapp.cs.clemson.edu/~boferre/metube/login.php' />";
}
?>
