<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Account</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/mediaDisplayFunctions.php';
	include 'functions/searchFunction.php';
	include 'functions/accountManagementFunctions.php';
?>


<html id="webPage">
<div id="container">
	<header id="headCont">
		<div id="headData">
			<span id="logoCont"><a href="index.php">logo</a></span>
			<span id="searchCont"> 
				<form id="searchForm" method="post">
					<input type="text" id="searchBar"  name="searchVal"><input type="submit" name="search" value="Browse" id="searchButton">
				</form>
				<?php
					if (isset($_POST['search'])) {
						$result = $_POST['searchVal'];
						search($result);
						unset($_POST['search']);
					}
				?>
			</span>
			<?php
				session_start();
				if (isset($_SESSION['accountID'])) {
					echo '<div class="dropdown">
							<button onclick="myFunction()" class="dropbtn">' . $_SESSION["displayname"] . '</button>
							<div  id="myDropdown" class="dropdown-content">
								<a href="account.php?id=' . $_SESSION["accountID"] . '">View Account</a>
								<a href="upload.php">Upload</a>
								<a href="functions/logoutFunction.php">Log Out</a>
							</div>
						</div>';
				} else {
					echo '<a id="menuCont" href="login.php">Log In</a> <a id="menuCont" href="register.php">Register</a>';
				}
			?>
		</div>
	</header>
	
<body>
	<div id="mainPageContent">
		<div id="selector">
			<table>
				<tr>
					<td>
						<a id="sidebarHead" href="index.php">Home</a> <br>
						
						<?php
							if (isset($_SESSION['accountID']) && $_SESSION['accountID'] == $_GET['id']) {
								echo '<a id="sidebarHead" href="account.php?section=vids&id='. $_GET['id'] .'">Your Videos</a> <br>';
								echo '<a id="sidebarHead" href="account.php?section=sub&id='. $_GET['id'] .'">Your Subscriptions</a> <br>';
								echo '<a id="sidebarHead" href="account.php?section=play&id='. $_GET['id'] .'">Your Playlists</a> <br>';
								echo '<a id="sidebarHead" href="account.php?section=msg&id='. $_GET['id'] .'">Messages</a> <br>';
								echo '<a id="sidebarHead" href="account.php?section=set&id='. $_GET['id'] .'">Account Settings</a> <br>';
							}
						?>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div id="accountContent">
			<?php
			
			if (!isset($_GET['section']) || ($_SESSION['accountID'] != $_GET['id'])) {
				if (isset($_SESSION['accountID']) && $_SESSION['accountID'] == $_GET['id']) {
					echo "<label id='heading'>Your Dashboard</label> <br>";
				} else {
					echo "<label id='heading'> Welcome to ";
					getAccountName($_GET['id']);
					echo "s channel</label> <br>";
					
					if (isset($_SESSION['accountID']) AND !empty($_SESSION['accountID'])) {
						if (checkIfSubbed($_GET['id']) == 1) {
							echo "<form method='post'>
									<input type='submit' name='unsubscribe' id='subscribe' value='Unsubscribe' /> <a id='messageLink' href='account.php?id=". $_SESSION['accountID'] ."&section=send&to=". $_GET['id'] ."'>Send A Message</a><br/>
								</form>";
								
							if (isset($_POST['unsubscribe'])) {
								unsubscribe($_GET['id']);
								unset($_POST['unsubscribe']);
							}
						} else {
							echo "<form method='post'>
									<input type='submit' name='subscribe' id='subscribe' value='Subscribe' /> <a id='messageLink' href='account.php?id=". $_SESSION['accountID'] ."&section=send&to=". $_GET['id'] ."'>Send A Message</a><br/>
								</form>";
								
							if (isset($_POST['subscribe'])) {
								subscribe($_GET['id']);
								unset($_POST['subscribe']);
							}

						}
					}
				}
				
				echo "<br><label id='heading'>Videos</label><br>";
				displayList('', '', $_GET['id'], 5);
			} else {
				if ($_GET['section'] == "vids") {
					echo "<label id='heading'>Your Videos</label><br>";
					mediaSettings();
					
				} elseif ($_GET['section'] == "sub") {
					echo "<label id='heading'>Your subscriptions</label><br>";
					showSubscribers();
					
				} elseif ($_GET['section'] == "play") {
					echo "<label id='heading'>Your playlists</label>";
					echo "<a id='linkButton' href='account.php?section=addtoplay&id=". $_GET['id'] ."'>Create A Playlist</a> <br>";
					getplaylistandLinks($_SESSION['accountID']);
					
				} elseif ($_GET['section'] == "msg") {
				 	echo "<label id='heading'>Messages</label><br>";
					displayCurrentConversations();
					
				}elseif ($_GET['section'] == "send") {
					echo "<label id='heading'>Currently Messaging:";getAccountName($_GET['to']);echo "</label><br>";
					displayMessages($_GET['to']);
					echo "<br><br><form method='post'>
						  <textarea name='msg' rows='5' cols='50'></textarea>
						  <br>
						  <input type='submit' name='sendmsg' value='Send Message'>
						</form>";
						
					if (isset($_POST['sendmsg'])) {
						sendMessage($_GET['to'], $_POST['msg']);
						unset($_POST['sendmsg']);
					}
						
				} elseif ($_GET['section'] == "set") {
					echo "<label id='heading'>Account Settings</label><br>";
					accSettings();
					
				} elseif ($_GET['section'] == "addtoplay") {
					echo "	<label id='heading'>Create A Playlist</label><br>
							<div id='createplayCont'>
								<label id='subtitle'>Enter a Title for your new playlist.</label>
								<form id='playtitleForm' method='post'>
									<input type='text' id='playTitleValInput'  name='titleVal'><input type='submit' name='addPlaylist' value='addPlaylist' id='addButton'>
								</form>
							</div>
					";
					
					if (isset($_POST['addPlaylist'])) {
						$result = $_POST['titleVal'];
						createPlaylist($_SESSION['accountID'], $result);
						unset($_POST['addPlaylist']);
					}
					
				}elseif ($_GET['section'] == "passchange") {
					passChange();
				} else {
					echo "<label id='heading'>You shouldn't be here</label><br>";
				}
			}
			?>
		</div>
		
		
	</div>
</body>

</div>
</html>
