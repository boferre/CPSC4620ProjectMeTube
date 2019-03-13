<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<title>MeTube - Home</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>


<html id="webPage">
<div id="container">
	<header id="headCont">
		<div id="headData">
			<span id="logoCont"><a href="index.php">logo</a></span>
			<span id="searchCont"> <input type="text" id="searchBar"  name="searchVal"><button type="button">Search</button></span>
			<?php
				session_start();
				if (isset($_SESSION['accountID'])) {
					echo '<a id="menuCont" href="functions/logoutFunction.php">Log Out</a> <a id="menuCont" href="upload.php">Upload</a> <a id="menuCont">Welcome, ' . $_SESSION["displayname"] . ': </a>' ;
				} else {
					echo '<a id="menuCont" href="login.php">Log In</a> <a id="menuCont" href="register.php">Register</a> <a id="menuCont" href="upload.php">Upload</a>';
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
		
					<div class="carousel js-carousel">
						<div class="item">test</div>
						<div class="item">test</div>
						<div class="item">test</div>
						<div class="item">test</div>
						<div class="item">test</div>
					</div>
					
				</td>
			</tr>

			<tr id="mediaPrev">
				<td>
					Media Preview Section
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
