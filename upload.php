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
	include 'functions/searchFunction.php';

?>


<html id="webPage">
<div id="container">
	<header id="headCont">
		<div id="headData">
			<span id="logoCont"><a href="index.php">logo</a></span>
			<span id="searchCont"> 
				<form id="searchForm" method="post">
					<input type="text" id="searchBar"  name="searchVal"><input type="submit" name="search" value="Search" id="searchButton">
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
			<form method="post" enctype="multipart/form-data">
				<div class="regCont" id="titleCont">
					<span class="heading" id="">Title</span> 
						<input type="text" id="vidTitle" name="vidTitle" placeholder="Enter the media title" maxlength="50" size="50">
					<br>
					<span class="heading" id="">Description</span> 
						<input type="text" id="vidDesc" name="description" placeholder="Enter your description here" maxlength="250" size="50">
					<br>
					<span class="heading" id="">Keywords</span> 
						<input type="text" id="vidKey" name="keywords" placeholder="Place a space between each keyword" maxlength="500" size="50">
					<br>
					<span class="heading" id="">Category</span>
						<select name="category">
							<option value="Auto & Vehicles">Auto & Vehicles</option>
							<option value="Beauty & Fashion">Beauty & Fashion</option>
							<option value="Comedy">Comedy</option>
							<option value="Education">Education</option>
							<option value="Entertainment">Entertainment</option>
							<option value="Family">Family</option>
							<option value="Food">Food</option>
							<option value="Gaming">Gaming</option>
							<option value="How-To">How-To</option>
							<option value="Music">Music</option>
							<option value="News & Politics">News & Politics</option>
							<option value="Nonprofit & Activism">Nonprofit & Activism</option>
							<option value="People">People</option>
							<option value="Pets">Pets</option>
							<option value="Science">Science</option>
							<option value="Sports">Sports</option>
							<option value="Travel">Travel</option>
						</select>
				</div>
				
				<div class="regCont" id="passCont">
					
						Select image to upload:
						<input type="file" name="file" id="file">
						<br>
						<input type="submit" value="Upload" name="submit">
				</div>
			</form>
			
			<?php
				if (isset($_POST['submit'])) {
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
