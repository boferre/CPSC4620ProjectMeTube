<!DOCTYPE html5>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/register.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Upload</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/uploadFunction.php';

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
		<div class="Title" id="titleCont">Media Upload</div>
		<div class="subTitle" id="titleCont">If you've never uploaded a video to MeTube then <a href="">click here</a> for the basic rundown.</div>
		<div id="infoCont">
			<form method="post">
				<div class="regCont" id="titleCont">
					<span class="heading" id="">Title</span> 
						<input type="text" id="vidTitle" name="vidTitle" placeholder="Enter the media title" maxlength="125">  
				</div>
				
				<div class="regCont" id="passCont">
					<form action="functions/uploadFunction.php" method="post" enctype="multipart/form-data">
						Select image to upload:
						<input type="file" name="fileToUpload" id="fileToUpload">
						<input type="submit" value="Upload" name="submit">
					</form>
				</div>
			</form>
			
			<?php
				if (isset($_POST['submit'])) {
					echo "upload1";
					upload();
				}
			?>
			
		</div>
	</div>
</body>

	<footer id="footCont">
		other links and information
	</footer>
</div>
</html>
