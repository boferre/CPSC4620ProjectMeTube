<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Media</title>
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
		<div id="mediaContentContainer">
			<?php
				$mediaId = $_GET["media"];
				displayPlayer($mediaId);
				addView($mediaId);
				if (isset($_POST['subscribe'])) {
					subscribe($_POST['idLogged']);
					unset($_POST['subscribe']);
				}
			?>
		</div>
		<div id="commentSectionContainer">
			<?php
				if (isset($_SESSION['accountID']) AND checkComs($mediaId) == 1) {
					echo "
						<form method='post'>
						  <textarea name='comment' rows='5' cols='50'></textarea>
						  <br>
						  <input type='submit' name='addComment' value='Add Comment'>
						</form>
					";
				}
				
				
				if (isset($_POST['addComment'])) {
					addComment($mediaId, $_SESSION['accountID']);
					unset($_POST['addComment']);
				}
			
			if (checkComs($mediaId) == 1) {
			echo '
				<div id="commentTitleHeader">
					Comments
				</div>
			';
			}
				displayComments($mediaId);
			?>
		</div>
	</div>
</body>	
</div>
</html>
