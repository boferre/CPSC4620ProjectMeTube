<!DOCTYPE html5>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/register.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Log In</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/loginFunctions.php';
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
		<div class="Title" id="titleCont">Welcome to MeTube!</div>
		<div class="subTitle" id="titleCont">If you have an account, please sign in below.</div>
		<div class="subTitle" id="titleCont">If you wish to register an account, <a href="register.php">click here</a>.</div>
		<div id="infoCont">
			<form method="post">
				<div class="regCont" id="loginCont">
					<span class="heading" id="nameHead">Email</span> 
						<input type="text" id="emailInput" name="email" placeholder="Enter Your Email" maxlength="35">  
				</div>
				
				<div class="regCont" id="passCont">
					<span class="heading" id="passHead">Password</span> 
						<input type="text" id="passInput" name="password" placeholder="Enter Password">
				</div>
				
				<div class="regCont" id="submitCont">
					<input type="submit" name="submit" value="Submit" id="submitButton">
				</div>
			</form>
			
			<?php
				if (isset($_POST['submit'])) {
					login();
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
