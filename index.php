<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Home</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/mediaDisplayFunctions.php';
?>


<html id="webPage">
<div id="container">
	<header id="headCont">
		<div id="headData">
			<span id="logoCont"><a href="index.php">logo</a></span>
			<span id="searchCont"> <input type="text" id="searchBar"  name="searchVal"><button type="button">Search</button></span>
			<?php
				session_start();
				if (isset($_SESSION['accountID'])) {
					echo '<div class="dropdown">
							<button onclick="myFunction()" class="dropbtn">' . $_SESSION["displayname"] . '</button>
							<div  id="myDropdown" class="dropdown-content">
								<a href="#">View Account</a>
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
		<table>
			<tr id="spotlightedVid">
				<td>
					spotlighted Media
					
				</td>
			</tr>
			
			<tr id="mediaPrev">
				<td>
					<div class="videoList">
						<?php displayList('', 'uploaded', 0);?>
					</div>
				</td>
			</tr>

			<tr id="mediaPrev">
				<td>
					<div class="videoList">
						<?php displayList('Most viewed', 'views', 0);?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
	<footer id="footCont">
		other links and information
	</footer>
</div>
</html>
