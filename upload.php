<!DOCTYPE html5>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/register.css" />
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
					echo '<a id="menuCont" href="functions/logoutFunction.php">Log Out</a> <a id="menuCont" href="upload.php">Upload</a> <a id="menuCont">Welcome, ' . $_SESSION["displayname"] . ': </a>' ;
				} else {
					echo '<a id="menuCont" href="login.php">Log In</a> <a id="menuCont" href="register.php">Register</a> <a id="menuCont" href="upload.php">Upload</a>';
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
					<span class="heading" id="">File to Upload</span> 
						<input type="file" name="fileToUpload" id="fileToUpload">
				</div>
				
				<div class="regCont" id="submitCont">
					<input type="submit" name="submit" value="Submit" id="submitButton">
				</div>
			</form>
			
			<?php
				if (isset($_POST['submit'])) {
					echo "starting";
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
