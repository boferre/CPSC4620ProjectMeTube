<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Browse</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/mediaDisplayFunctions.php';
	include 'functions/searchFunction.php';
	chmod('/uploads/*', 0755);
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
							if (isset($_SESSION['accountID'])) {
								echo '<a id="sidebarHead" href="browse.php?subs=1">Subscriptions</a> <br>';
								echo '<a id="sidebarHead" href="browse.php?playlist=1">Playlists</a> <br>';
							} else {
								echo '<a id="sidebarHead" href="browse.php?chan=1">Channels</a> <br>';
							}
						?>
						
					</td>
				</tr>
				
				<tr>
					<td>
						<label id="categoryHeader">Categories</label><br>
						<a id="categoryHead" href="browse.php?cat=AutoVehicles">Auto & Vehicles</a> <br>
						<a id="categoryHead" href="browse.php?cat=BeautyFashion">Beauty & Fashion</a> <br>
						<a id="categoryHead" href="browse.php?cat=Comedy">Comedy</a> <br>
						<a id="categoryHead" href="browse.php?cat=Education">Education</a> <br>
						<a id="categoryHead" href="browse.php?cat=Entertainment">Entertainment</a> <br>
						<a id="categoryHead" href="browse.php?cat=Family">Family</a> <br>
						<a id="categoryHead" href="browse.php?cat=Food">Food</a> <br>
						<a id="categoryHead" href="browse.php?cat=Gaming">Gaming</a> <br>
						<a id="categoryHead" href="browse.php?cat=How-To">How-To</a> <br>
						<a id="categoryHead" href="browse.php?cat=Music">Music</a> <br>
						<a id="categoryHead" href="browse.php?cat=NewsPolitics">News & Politics</a> <br>
						<a id="categoryHead" href="browse.php?cat=Nonprofit&Activism">Nonprofit & Activism</a> <br>
						<a id="categoryHead" href="browse.php?cat=People">People</a> <br>
						<a id="categoryHead" href="browse.php?cat=Pets">Pets</a> <br>
						<a id="categoryHead" href="browse.php?cat=Science">Science</a> <br>
						<a id="categoryHead" href="browse.php?cat=Sports">Sports</a> <br>
						<a id="categoryHead" href="browse.php?cat=Travel">Travel</a> <br>
					</td>
				</tr>
			</table>
		</div>
		
		<div id="resultsCont">
			<?php
				if(isset($_GET['searched']) && !empty($_GET['searched'])) {
					displayResults($_GET['searched'], 0);
				} elseif (isset($_GET['cat']) && !empty($_GET['cat'])) {
					echo $_GET['cat'];
					echo "<br>";
					displayList($_GET['cat'], 'uploaded', 0, 1);
				} elseif (isset($_GET['subs']) && !empty($_GET['subs'])) {
					echo '<div class="contentTitle">Subscriptions</div>';
					displaySubVideos();
					
				} elseif (isset($_GET['playlist']) && !empty($_GET['playlist'])) {
					echo '<div class="contentTitle">Your Playlist</div>';
					displayPlaylist($_SESSION['accountID']);
				} else {
					displayList('', 'uploaded', 0, 0);
				}
				
			?>
		</div>
	</div>
</body>
	
</div>
</html>
