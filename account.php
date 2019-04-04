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
								echo '<a id="sidebarHead" href="http://webapp.cs.clemson.edu/~boferre/metube/account.php?section=vids&id='. $_GET['id'] .'">Your Videos</a> <br>';
								echo '<a id="sidebarHead" href="http://webapp.cs.clemson.edu/~boferre/metube/account.php?section=sub&id='. $_GET['id'] .'">Your Subscriptions</a> <br>';
								echo '<a id="sidebarHead" href="http://webapp.cs.clemson.edu/~boferre/metube/account.php?section=play&id='. $_GET['id'] .'">Your Playlists</a> <br>';
								echo '<a id="sidebarHead" href="http://webapp.cs.clemson.edu/~boferre/metube/account.php?section=msg&id='. $_GET['id'] .'">Messages</a> <br>';
								echo '<a id="sidebarHead" href="http://webapp.cs.clemson.edu/~boferre/metube/account.php?section=set&id='. $_GET['id'] .'">Account Settings</a> <br>';
							}
						?>
						
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>

</div>
</html>
