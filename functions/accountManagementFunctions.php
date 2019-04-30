<?php
	
	function getAccountName($usr) {
		include 'server.php';
		
		$sql = "SELECT displayname FROM account WHERE accountID=$usr";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo $row["displayname"];
		} else {
			echo "No account found";
		}
	}
	
	
	function getPlayList($acc) {
		include 'server.php';
		
		$sql = "SELECT title FROM playlist WHERE title='Favorites' AND accountID=$acc;";
		$result = $conn->query($sql);
		if ($result->num_rows <= 0) {
			$sql = "SELECT COUNT(ListID) FROM playlist;";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$count = $row['COUNT(ListID)']+1;
			
			$insertSQL = "INSERT INTO playlist VALUES($count, $acc , 'Favorites');";
			$result = $conn->query($insertSQL);
		}
		
		$sql = "SELECT title, ListID FROM playlist WHERE accountID=$acc;";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
				echo "<option value='functions/addToPlaylist.php?list=". $row['ListID'] ."&media=". $_GET['media'] ."'>" . $row['title'] . "</option>";
			}
		}
		
	}
	
	function getplaylistandLinks($acc) {
		include 'server.php';
		$sql = "SELECT ListID, title FROM playlist WHERE accountID=$acc;";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "
					<div id='playlistCont'>
						<div id='playlisttitle'><label id='subtitle'>". $row['title'] ."</span>
							<form id='rmvaPlaylist' method='post'>
								<button id='searchButton' name='rmvPlaylist' value='". $row['ListID'] ."' type='submit'>Delete Playlist</button>
							</form> 
							<div id='playlistlinks'>
							";
							
				if (isset($_POST['rmvPlaylist'])) {
					$data = $_POST['rmvPlaylist'];
					deletePlaylist($data);
					unset($_POST['rmvPlaylist']);
				}
				
				$sql = "SELECT mediaLink FROM playlistLinks WHERE ListID=" . $row['ListID'] .";";
				$linkResults = $conn->query($sql);
				$listID = $row['ListID'];
				if ($linkResults->num_rows > 0) {
					while ($row = $linkResults->fetch_assoc()) {
						echo "<div id='mediaResultCont'>";
						displayList(0, $row['mediaLink'], 0, 6);
						echo "
								<form id='rmvFromPlaylist' method='post'>
									<button id='searchButton' name='rmvFromPlay' value='". $row['mediaLink'] ."' type='submit'>Remove</button>
								</form>
						";
						
						if (isset($_POST['rmvFromPlay'])) {
							$data = $_POST['rmvFromPlay'];
							rmvFromPlaylist($data, $listID);
							unset($_POST['rmvFromPlay']);
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
	
	
	function createPlaylist($acc, $title) {
		include 'server.php';
		$sql = "SELECT COUNT(ListID) FROM playlist;";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$count = $row['COUNT(ListID)']+1;
			
		$insertSQL = "INSERT INTO playlist VALUES($count, $acc , '$title');";
		$result = $conn->query($insertSQL);
	}
	
	
	function addToPlaylist($acc, $mediaID, $ListID) {
		include 'server.php';
		$sql = "SELECT * FROM playlist WHERE ListID=$ListID AND accountID=$acc;";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$sql = "SELECT * FROM playlistLinks WHERE ListID=$ListID AND mediaLink=$mediaID;";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				return;
			} else {
				$sql = "INSERT INTO playlistLinks VALUES($ListID, $mediaID);";
				$result = $conn->query($sql);
			}
		}	
	}
	

	function rmvFromPlaylist($media, $list) {
		include 'server.php';
		$exec = "DELETE FROM playlistLinks WHERE ListID=$list AND mediaLink=$media;";
		$conn->query($exec);
		header("Refresh:0");
	}
	
	
	function deletePlaylist($ListID) {
		include 'server.php';
		
		echo $ListID;
		$exec = "DELETE FROM playlistLinks WHERE ListID=$ListID;";
		$conn->query($exec);
		$exec = "DELETE FROM playlist WHERE ListID=$ListID;";
		$conn->query($exec);
		header("Refresh:0");
	}
	
	
	function subscribe($usr) {
		include 'server.php';
		$subscriber = $_SESSION['accountID'];
		
		if (checkIfSubbed($usr) == 1) {
			return;
		}
		
		$sql = "INSERT INTO subscribers VALUES ('$subscriber', '$usr');";
		$conn->query($sql);
		header("Refresh:0");
		
	}
	
	
	function unsubscribe($usr) {
		include 'server.php';
		$subscriber = $_SESSION['accountID'];
		
		if (checkIfSubbed($usr) == 0) {
			return;
		}
		
		$sql = "DELETE FROM subscribers WHERE subscriberID=$subscriber AND subscribedID=$usr;";
		$conn->query($sql);
		header("Refresh:0");
	}
	
	
	function checkIfSubbed($usr) {
		include 'server.php';
		$subscriber = $_SESSION['accountID'];
		$sql = "SELECT * FROM subscribers WHERE subscribedID=$usr AND subscriberID=$subscriber;";
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			return 1;
		}
		return 0;
	}
	
	
	function showSubscribers() {
		include 'server.php';
		$subscriber = $_SESSION['accountID'];
		$sql = "SELECT subscribedID FROM subscribers WHERE subscriberID=$subscriber;";
		
		$result = $conn->query($sql);
		
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
					echo "<a id='subscribedAccount' href='account.php?id=" . $row['subscribedID'] . " '>";
					getAccountName($row['subscribedID']);
					echo "</a><br>";
			}
		} else {
			echo "<label id='alert'>You haven't subscribed to anyone yet!</label>";
		}
	}
	
	
	function mediaSettings() {
		include 'server.php';
		$usr = $_SESSION['accountID'];
		
		$sql = "SELECT mediaID, title, link, uploaded, views, type, comenabled FROM media WHERE accountID=$usr;";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
					if ($row["type"] == 'mp4' || $row["type"] == 'webm' || $row["type"] == 'ogg') {
					$imageLink = $row["link"];
					echo "<div id='mediaResultCont'>";
					echo "<a id='deleteButton' href='functions/deleteMedia.php?media=". $row["mediaID"] ."'><span class='deleteMedia'>Delete Media</span></a><br>";
					echo "<a href='media.php?media=" . $row["mediaID"] . "&com=" . $row["comenabled"] ."'><div class='item' style='background-image: url(media/videoplaceholder.jpg); background-repeat: no-repeat; background-size: 100% 100%;'><span class='mediaTitle'>" . $row["title"] . "</span></div></a>";
					echo "</div>";
				} else {
					$imageLink = $row["link"];
					echo "<div id='mediaResultCont'>";
					echo "<a id='deleteButton' href='functions/deleteMedia.php?media=". $row["mediaID"] ."'><span class='deleteMedia'>Delete Media</span></a><br>";
					echo "<a href='media.php?media=" . $row["mediaID"] . "&com=" . $row["comenabled"] ."'><div class='item' style='background-image: url(" . $imageLink . "); background-repeat: no-repeat; background-size: 100% 100%;'><span class='mediaTitle'>" . $row["title"] . "</span><span class='deleteMedia'></span></div></a>";
					echo "</div>";
				}
			}
		} else {
			echo "<label id='alert'>You haven't uploaded anything yet!</label>";
		}
	}
	
	
	function displayMessages($acc) {
		include 'server.php';
		$usr = $_SESSION['accountID'];
		
		$sql = "SELECT * FROM messaging WHERE (starter=$usr AND receiver=$acc) OR (starter=$acc AND receiver=$usr);";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo "<div id='conversationCont'";
			echo $row['message'];
			echo "</div>";
		} else {
			echo "<label id='alert'>You haven't started a conversation with this person yet!</label>";
		}
	}
	
	
	function displayCurrentConversations() {
		include 'server.php';
		
		if (isset($_SESSION['accountID'])) {
			$usr = $_SESSION['accountID'];
		} else {
			return;
		}
		
		$sql = "SELECT * FROM messaging WHERE starter=$usr OR receiver=$usr ORDER BY updated DESC;";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			while(($row = $result->fetch_assoc())) {
				if ($row['starter']==$usr) {
					echo "<a href='account.php?id=3&section=send&to=" . $row['receiver'] . " '>";
					getAccountName($row['receiver']);
					echo "</a><br>";
				} else {
					echo "<a href='account.php?id=3&section=send&to=" . $row['starter'] . " '>";
					getAccountName($row['starter']);
					echo "</a><br>";
				}
			}
		} else {
			echo "<label id='alert'>You have no messages!</label>";
		}
	}
	
	
	function sendMessage($acc, $msg) {
		include 'server.php';
		
		if (isset($_SESSION['accountID'])) {
			$usr = $_SESSION['accountID'];
		} else {
			return;
		}
		
		$sql = "SELECT * FROM messaging WHERE (starter=$usr AND receiver=$acc) OR (starter=$acc AND receiver=$usr);";
		$result = $conn->query($sql);
		
		// Send a message during a current convo
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$starter=$row['starter'];
			$receiver=$row['receiver'];
			
			
			$usrDisplay = accountName($usr);
			$date = date('m/d/Y h:i:s a', time());
			$newmsg = $row['message'] . "<span>$usrDisplay - $date</span><br>
											<span>$msg</span><br><br>
			";
			
			$newmsg = mysql_escape_string($newmsg);
			
			$addMsg = "UPDATE messaging SET message='$newmsg', updated=NOW() WHERE starter=$starter AND receiver=$receiver;";
			$result = $conn->query($addMsg);
			
			header("Refresh:0");
			echo "<label id='alert'>Message sent!</label>";
			return;
			
		// Start a new conversation
		} else {
			$usrDisplay = accountName($usr);
			$date = date('m/d/Y h:i:s a', time());
			$newmsg = "<span>$usrDisplay - $date</span><br>
							<span>$msg</span><br><br>
			";
			
			$addMsg = "INSERT INTO messaging VALUES($usr, $acc, '$newmsg', NOW());";
			$result = $conn->query($addMsg);
			
			header("Refresh:0");
			echo "<label id='alert'>Conversation started!</label>";
			return;
		}
	}
	
	
	function accountName($usr) {
		include 'server.php';
		
		$sql = "SELECT displayname FROM account WHERE accountID=$usr";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row["displayname"];
		}
		
		return;
	}
	
	
	function accSettings() {
		include 'server.php';
		$usr = $_SESSION['accountID'];
		
		$sql = "SELECT * FROM account WHERE accountID=$usr;";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$sql = "SELECT SUM(views) FROM media WHERE accountID=$usr;";
		$result = $conn->query($sql);
		$total = $result->fetch_assoc();
		$totalViews = $total['SUM(views)'];
		
		echo "
			<br>
			<form id='accChangeForm' method='post'>
				<label id='subHead'>First Name: ". $row['Fname'] ."</label><br>
				<label id='subHead'>Last Name: ". $row['Lname'] ." </label><br>
				<label id='subHead'>Your Account ID: ". $row['accountID'] ."</label><br>
				<label id='subHead'>In total, your views for all videos is: $totalViews</label><br>
				<label id='subHead'>Your Display Name: </label><input type='text' name='displayname' value='". $row['displayname'] ."'><br>
				<input type='submit' name='submitChanges' value='Submit Changes'><input type='submit' name='changePassword' value='Change Password'>
			</form>
		
		";
		
		if (isset($_POST['submitChanges'])) {
			unset($_POST['submitChanges']);
			$newDisplay = $_POST['displayname'];
			
			$sql = "UPDATE account SET displayname='$newDisplay' WHERE accountID=$usr";
			$result = $conn->query($sql);
			$_SESSION["displayname"] = $newDisplay;
			header("Refresh:1");
			echo "<label id='alert'>Changes submitted and made! Refreshing now.</label>";
		} elseif (isset($_POST['changePassword'])) {
			unset($_POST['changePassword']);
			header("Location: account.php?section=passchange&id=". $_SESSION["accountID"]);
		}
		
	}
	
	
	function passChange() {
		include 'registerFunction.php';
		include 'server.php';
		
		echo "<label id='heading'>Change Your Password</label><br>
			  <label id='alert'>Please enter your email, old password, and new password.</label>
		";
		echo "
			<form method='post'>
				<div class='regCont' id='emailCont'><span class='heading' id='emailHead'>Email</span> 
					<input type='text' id='emailInput' name='email' placeholder='Enter Email' maxlength='35'></div>
				<div class='regCont' id='passCont'><span class='heading' id='passHead'>Your Old Password</span> 
					<input type='password' id='passInput' name='oldpassword' placeholder='Enter Old Password' maxlength='15'> 
				<div class='regCont' id='passCont'><span class='heading' id='passHead'>Your New Password</span> 
					<input type='password' id='passInput' name='newpassword' placeholder='Enter New Password' maxlength='15'>
				<br><input type='submit' name='passchange' value='Change Password'>
			</form><br><br>
		";
		
		if (isset($_POST['passchange'])) {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$oldpass = mysqli_real_escape_string($conn, $_POST['oldpassword']);
			$newpass = mysqli_real_escape_string($conn, $_POST['newpassword']);
			
			$value = $email . hashuser($oldpass);
			$id = $_SESSION['accountID'];
			
			
			$sql = "SELECT * FROM account WHERE username='$value' AND accountID=$id;";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				$newvalue = $email . hashuser($newpass);
				$sql = "UPDATE account SET username='$newvalue' WHERE accountID=$id;";
				$result = $conn->query($sql);
				
				echo "<label id='alert'>Your password has been changed, the effects will take place once you log in again.</label>";
			} else {
				echo "<label id='alert'>The email or old password doesnt match any accounts! Try again.</label>";
			}
			
			unset($_POST['passchange']);
		}
	}
	
	
?>

