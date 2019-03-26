<?php
	
	
	function displayList($category, $order, $user) {
		// Always include this file in order to connect to database
		include 'server.php';
		
		$displayNumber = 0;
		
		$sql = "SELECT mediaID, title, link, uploaded, views, category FROM media ORDER BY $order;";
		$result = $conn->query($sql);
		
		if ($category == '') {
			echo '<div class="contentTitle">New Videos</div>';
		} else {
			echo '<div class="contentTitle">' . $category . ' Videos</div>';
		}
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc()) && ($displayNumber <= 20)) {
				$imageLink = $row["link"];
				echo "<a href='http://webapp.cs.clemson.edu/~boferre/metube/media.php?media=" . $row["mediaID"] . "'><div class='item' style='background-image: url(" . $imageLink . "); background-repeat: no-repeat; background-size: 100% 100%;'><span class='mediaTitle'>" . $row["title"] . "</span></div></a>";
				$displayNumber++;
			}
		} else {
			echo "0 results";
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
				if (strtolower($row["type"]) == "jpg" || strtolower($row["type"]) == "png" || strtolower($row["type"]) == "gif") {
					echo "<img id='mediaCont' src=". $imageLink .">";
				} elseif (strtolower($row["type"]) == "mp4" || strtolower($row["type"]) == "webm" || strtolower($row["type"]) == "ogg") {
					echo "
						<video controls idth='640' height='360'>
							<source src='http://webapp.cs.clemson.edu/~boferre/metube/" . $imageLink .  "' type='video/mp4'>
						</video>
					";
				}
			}
		} else {
			echo "No media found!";
		}
	}

?>