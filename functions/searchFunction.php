<?php
	function search($keyword) {
		echo "<meta http-equiv='refresh' content='0;url=http://webapp.cs.clemson.edu/~boferre/metube/browse.php?searched=$keyword' />";
	}
	
	
	function displayResults($data, $type) {
		echo "<span id='Header'>Searching for $data</span><br>";
		echo "<span id='subHead'>Here is what we found!</span><br>";
		echo "<br><span id='subHead'>Results that matched Accounts</span><br>";
		displayList('', $data, 0, 3);
		echo "<div id='titleResultCont'><br><span id='subHead'>Results that matched keywords</span><br></div>";
		displayList('', $data, 0, 4);
		echo "<div id='titleResultCont'><br><span id='subHead'>Results that matched Title</span><br></div>";
		displayList('', $data, 0, 2);
		
	
	}
	
		function displayPlaylist($acc) {
		include 'server.php';
		$sql = "SELECT ListID, title FROM playlist WHERE accountID=$acc;";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "
					<div id='playlistCont'>
						<div id='playlisttitle'><label id='subtitle'>". $row['title'] ."</span>
							<div id='playlistlinks'>
							";
				
				$sql = "SELECT mediaLink FROM playlistLinks WHERE ListID=" . $row['ListID'] .";";
				$linkResults = $conn->query($sql);
				$listID = $row['ListID'];
				if ($linkResults->num_rows > 0) {
					while ($row = $linkResults->fetch_assoc()) {
						echo "<div id='mediaResultCont'>";
						displayList(0, $row['mediaLink'], 0, 6);
						
						if (isset($_POST['rmvFromPlay'])) {
							$data = $_POST['rmvFromPlay'];
							rmvFromPlaylist($data, $listID);
						}

						echo "</div>";
					}
				} else {
					echo "<label id='alert'>You haven't added any videos to this playlist!</label>";
				}
				
				echo"	
							</div>
						</div>
					</div>
					";
			}
		} else {
			echo "<label id='alert'>You haven't made any playlist yet!</label>";
		}
	}
	

?>