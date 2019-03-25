<?php

function uploadIntoDatabase($dir, $user) {
	include 'server.php';
	
	$sql = "SELECT COUNT(mediaID) FROM media;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$mediaID = $row['COUNT(mediaID)'] + 1;
	$title = mysqli_real_escape_string($conn, $_REQUEST['vidTitle']);
	$link = $dir;
	
	// Insert into
	$sql = "INSERT INTO media VALUES ('$mediaID', '$user', '$link', '$title', 'description', CURDATE(), 0, 0);";
	//echo $sql;	
	$conn->query($sql);
	
	
	// Always close the connection
	$conn->close();
	
}


function upload(){
	$username = $_SESSION['accountID'];
	$result = 0;
	

	//Create Directory if doesn't exist
	if(!file_exists('uploads/'))
		mkdir('uploads/', 0755);
	$dirfile = 'uploads/'.$username.'/';
	if(!file_exists($dirfile))
		mkdir($dirfile, 0755);


		if($_FILES["file"]["error"] > 0 )
		{ $result=$_FILES["file"]["error"];} //error from 1-4
		else
		{
		  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
		  
		  if(file_exists($upfile))
		  {
				$result= 5;
		  }
		  else{
				if(is_uploaded_file($_FILES["file"]["tmp_name"]))
				{
					if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
					{
						$result= 6; //Failed to move file from temporary directory
					}
				}
				else  
				{
						$result=7; //upload file failed
				}
			}
		}
		
		//You can process the error code of the $result here.
		if ($result == 0) {
			uploadIntoDatabase($upfile, $username);
			chmod($upfile, 0755);
			echo "<span class='warning' id='warning'>Your file has been uploaded!</span>";
		}
}

?>