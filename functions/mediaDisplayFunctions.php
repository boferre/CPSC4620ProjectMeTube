<?php
	
	function displayList($category, $data, $user, $type) {
		// Always include this file in order to connect to database
		include 'server.php';
		
		$displayNumber = 0;
		$sql = '';
		
		// Determine our query statement
		// Display based on order
		if ($type == 0) {
			$sql = "SELECT mediaID, title, link, uploaded, views, category, type, comenabled FROM media ORDER BY $data;";
			if ($category == '') {
				echo '<div class="contentTitle">New Videos</div>';
			} else {
				echo '<div class="contentTitle">' . $category . ' Videos</div>';
			}
		// Display based on category
		} elseif ($type == 1) {
			$sql = "SELECT mediaID, title, link, uploaded, views, type, category, comenabled FROM media WHERE category='$category';";
		// Display based on Title
		} elseif ($type == 2) {
			$sql = "SELECT mediaID, title, link, uploaded, views, category, type, comenabled FROM media WHERE title='$data';";
		// Display based on Account
		} elseif ($type == 3) {
			$acc = 0;
			$sql = "SELECT displayname, accountID FROM account WHERE displayname LIKE '%$data%';";
			$nameResult = $conn->query($sql);
			
			if ($nameResult->num_rows > 0) {
				echo "<div id='accountSearchResults'>";
				while(($row = $nameResult->fetch_assoc())) {
					echo "<a href='http://webapp.cs.clemson.edu/~boferre/metube/account.php?id=" . $row["accountID"] . "'>" . $row["displayname"] . "</a><br>";
				}
				echo "</div>";
			} else {
				echo "0 results";
			}
			
			return;
		// Display based on keywords
		} elseif ($type == 4) {
			$sql = "SELECT mediaID, title, link, uploaded, views, category, type, comenabled FROM media WHERE keywords LIKE '%$data%' ;";
		} else {
			echo "No given type.";
			return;
		}

		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			echo "<div id='mediaResultCont'>";
			while(($row = $result->fetch_assoc())) {
				
				if ($row["type"] == 'mp4' || $row["type"] == 'webm' || $row["type"] == 'ogg') {
					$imageLink = $row["link"];
				echo "<a href='http://webapp.cs.clemson.edu/~boferre/metube/media.php?media=" . $row["mediaID"] . "&com=" . $row["comenabled"] ."'><div class='item' style='background-image: url(media/videoplaceholder.jpg); background-repeat: no-repeat; background-size: 100% 100%;'><span class='mediaTitle'>" . $row["title"] . "</span></div></a>";
				} else {
					$imageLink = $row["link"];
				echo "<a href='http://webapp.cs.clemson.edu/~boferre/metube/media.php?media=" . $row["mediaID"] . "&com=" . $row["comenabled"] ."'><div class='item' style='background-image: url(" . $imageLink . "); background-repeat: no-repeat; background-size: 100% 100%;'><span class='mediaTitle'>" . $row["title"] . "</span></div></a>";
				}
				$displayNumber++;
			}
			echo "</div>";
		} else {
			echo "0 results<br>";
		}
		
	}
	
	
	function displayPlayer($mediaID) {
		// Always include this file in order to connect to database
		include 'server.php';
		
		$sql = "SELECT mediaID, accountID, title, link, uploaded, views, category, keywords, description, type FROM media WHERE mediaID=$mediaID ;";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
				$imageLink = $row["link"];
				
				echo " 
						<span id='mediaTitle'>" . $row['title'] . "</span>
						<br>
						<div id='mediaCont'>
					 ";
				
				if (strtolower($row["type"]) == "jpg" || strtolower($row["type"]) == "png" || strtolower($row["type"]) == "gif") {
					echo "<img id='mediaImage' src=". $imageLink .">";
				} elseif (strtolower($row["type"]) == "mp4" || strtolower($row["type"]) == "webm" || strtolower($row["type"]) == "ogg") {
					echo "
						
						<video controls idth='720' height='460'>
							<source src='http://webapp.cs.clemson.edu/~boferre/metube/" . $imageLink .  "' type='video/mp4'>
						</video>
					";
				}
				
				$sql = "SELECT displayname FROM account WHERE accountID=" . $row['accountID'] . ";";
				$nameResult = $conn->query($sql);
				$name = $nameResult->fetch_assoc();
				
				echo "
						</div>
						<div id='mediaInfoCont'>
							<br>
							<span id='mediaInfoUploader'>Uploded by: " . $name['displayname'] . "</span> <span id='mediaInfoUploader'>Uploded On: " . $row['uploaded'] . "</span> <span id='mediaInfoUploader'>Total Views: " . $row['views'] . "</span>
							<br>
							<span id='mediaInfoUploader'>Description: " . $row['description'] . "</span>
							<br>
							<span id='mediaInfoUploader'>Category: " . $row['category'] . "</span>
							<br>
							<a id='downloadButton'>Download</a>
						</div>
					 ";
			}
		} else {
			echo "No media found!";
		}
	}
	
	
	function displayComments ($mediaID, $com) {
		// Always include this file in order to connect to database
		include 'server.php';
		
		if ($com == 0) {
			return;
		}
		
		$sql = "SELECT commentID, accountID, comment, reply FROM comments WHERE mediaID=$mediaID ORDER BY posted DESC;";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
				
				//Check if comment is a reply or a OP comment
				if ($row["reply"] == 0) {
					$sql = "SELECT displayname FROM account WHERE accountID=" . $row['accountID'] . ";";
					$nameResult = $conn->query($sql);
					
					$name = $nameResult->fetch_assoc();
					
					echo "<div id='commentBox'>
							<span id='commentorName'>" . $name['displayname'] ."</span>
							<br>
							<span id='comment'>" . $row['comment'] . "</span>
						  </div>
						 ";
						  
					// Show replies to comment, replies are linked by commentID and reply row
					$sql = "SELECT accountID, comment FROM comments WHERE mediaID=$mediaID AND reply=" . $row['commentID'] . ";";
					$replyResult = $conn->query($sql);
					
					if ($replyResult->num_rows > 0) {
						while(($replyRow = $replyResult->fetch_assoc())) {
								$sql = "SELECT displayname FROM account WHERE accountID=" . $replyRow['accountID'] . ";";
								$nameResult = $conn->query($sql);
								
								$name = $nameResult->fetch_assoc();
								
								echo "<div id='replyBox'>
										<span id='commentorName'>" . $name['displayname'] ."</span>
										<br>
										<span id='comment'>" . $replyRow['comment'] . "</span>
									  </div>
									  <br>";
						}
					} else {
						echo "There are currently no replies to this comment.";
					}
					
					echo "<br>";
				}
				
			}
		} else {
			echo "There are currently no comments.";
		}
	}
	
	
	function addComment($mediaID, $accountID, $com) {
		// Always include this file in order to connect to database
		include 'server.php';
		
		$sql = "SELECT COUNT(commentID) FROM comments;";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	
		$commentID = $row['COUNT(commentID)'] + 1;
		
		// Get other variables
		$comment = mysqli_real_escape_string($conn, $_REQUEST['comment']);
		
		if ($com == 1) {
			// Insert into
			$sql = "INSERT INTO comments VALUES ('$commentID', '$accountID', '$comment', 0, $mediaID, CURDATE());";
			//echo $sql;	
			$conn->query($sql);
			// Always close the connection
			$conn->close();
		} else {
			
		}
		
	}

?>