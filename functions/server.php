<!--Do not change the information in this file unless you wish to connect to a different database with the same tables.-->

<?php
	$servername = "mysql1.cs.clemson.edu";
	$username = "PrjctMTb_kdsy";
	$password = "CPSC4620";
	$dbname = "ProjectMeTube_xvky";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

?>