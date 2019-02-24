
<!DOCTYPE html>
<html>
<body>

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

$sql = "SELECT accountID, username, displayname FROM account";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["accountID"]. " - Name: ". $row["username"]. " " . $row["displayname"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?> 

</body>
</html>