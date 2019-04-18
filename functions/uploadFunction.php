<?php

function uploadIntoDatabase($dir, $user) {
	include 'server.php';
	
	$sql = "SELECT MAX(mediaID) FROM media;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$mediaID = $row['MAX(mediaID)'] + 1;
	$title = mysqli_real_escape_string($conn, $_REQUEST['vidTitle']);
	$link = $dir;
	$desc = mysqli_real_escape_string($conn, $_REQUEST['description']);
	$key = mysqli_real_escape_string($conn, $_REQUEST['keywords']);
	$cat = mysqli_real_escape_string($conn, $_REQUEST['category']);
	$comm = mysqli_real_escape_string($conn, $_REQUEST['comms']);
	$type = pathinfo($dir);
	$type = $type['extension'];
	$type = strtolower($type);
	
	
	// Insert into
	$sql = "INSERT INTO media VALUES ('$mediaID', '$user', '$link', '$title', '$desc', CURDATE(), 0, '$key', '$cat', '$type', $comm);";
	//echo $sql;	
	$conn->query($sql);
	
	
	// Always close the connection
	$conn->close();
	
}


function upload(){
	$username = $_SESSION['accountID'];
	$result = 0;
	$dirfile = 'uploads/'.$username.'/';
	

	//Create Directory if doesn't exist
	if(!file_exists($dirfile)) {
		mkdir($dirfile, 0755);
	}
	
	chmod($dirfile, 0755);

		if($_FILES["file"]["error"] > 0 ){ 
			$result=$_FILES["file"]["error"];
		} else {
		  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
		  
		  if(empty($_REQUEST['vidTitle'])) {
				echo "<span class='warning' id='warning'>You must enter a title for your media!</span>";
				return;
		  }
		  
		  if(file_exists($upfile)) {
				echo "<span class='warning' id='warning'>This file already exists!</span>";
				return;
		  } else{
				if(is_uploaded_file($_FILES["file"]["tmp_name"])) {
					$type = pathinfo($upfile);
					$type = $type['extension'];
					$type = strtolower($type);
					//if (strcmp($type, "jpg") !== 0 or strcmp($type, "mp4") !== 0 or strcmp($type, "png") !== 0 or strcmp($type, "gif") !== 0 or strcmp($type, "ogg") !== 0 or strcmp($type, "webm") !== 0)
					if (strcmp($type, "jpg") != 0) {
						if (strcmp($type, "mp4") != 0) {
							if (strcmp($type, "png") != 0) {
								if (strcmp($type, "gif") != 0) {
									if (strcmp($type, "ogg") != 0) {
										if (strcmp($type, "webm") != 0) {
											echo "<span class='warning' id='warning'>Cannot upload that file format!</span>";
											return;
										}
									}
								}
							}
						}
						
					}
					
					if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile)) {
						echo "<span class='warning' id='warning'>Failed to move file!</span>";
						return;
					}
				} else {
						echo "<span class='warning' id='warning'>Uploading file failed!</span>";
						return;
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