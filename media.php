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
								<a href="account.php">View Account</a>
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
			?>
		</div>
		<div id="commentSectionContainer">
			<?php
			
				$com = $_GET["com"];
				if (isset($_SESSION['accountID']) AND $com == 1) {
					echo "
						<form method='post'>
						  <textarea name='comment' rows='5' cols='50'></textarea>
						  <br>
						  <input type='submit' name='submit' value='Add Comment'>
						</form>
					";
				}
				
				
				if (isset($_POST['submit'])) {
					addComment($mediaId, $_SESSION['accountID'], $com);
				}
			
			if ($com == 1) {
			echo '
				<div id="commentTitleHeader">
					Comments
				</div>
			';
			}
				displayComments($mediaId, $com);
			?>
		</div>
	</div>
</body>	
</div>
</html>
