<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/register.css" />
	<script type="text/javascript" src="scripts/dropdown.js"></script>
	<title>MeTube - Registration</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	include 'functions/registerFunction.php';
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
		<div class="regTitle" id="titleCont">Fill out the following information to register!</div>
		<div id="infoCont">
		
		<form method="post">
			<div class="regCont" id="fullNameCont"><span class="heading" id="nameHead">Full Name</span> 
				<input type="text" id="nameInput" name="fName" placeholder="Enter First Name" value="<?php displayVar(1); ?>" maxlength="25"> 
				<input type="text" id="nameInput" name="lName" placeholder="Enter Last Name" value="<?php displayVar(2); ?>" maxlength="25"></div>
			<div class="regCont" id="emailCont"><span class="heading" id="emailHead">Email</span> 
				<input type="text" id="emailInput" name="email" placeholder="Enter Email" value="<?php displayVar(3); ?>" maxlength="35"></div>
			<div class="regCont" id="accName"><span class="heading" id="displayHead">Display Name</span> 
				<input type="text" id="nameInput" name="dName" placeholder="Enter Display Name" value="<?php displayVar(4); ?>" maxlength="25"></div>
			<div class="regCont" id="passCont"><span class="heading" id="passHead">Password</span> 
				<input type="text" id="passInput" name="password" placeholder="Enter Password"> 
				<input type="text" id="passInput" name="passwordComp" placeholder="Confirm Password"></div>
			<div class="regCont" id="secQueCont"><span class="heading" id="secHead">Security Question</span> 
				<select name="secQuestion">
				  <option value="1">What was the name of your first pet?</option>
				  <option value="2">What was the name of the steet you lived on?</option>
				  <option value="3">What was the name of your best friend?</option>
				  <option value="4">What was the name of your high school?</option>
				</select> <input type="text" id="secAnInput" name="secAnswer" value="<?php displayVar(5); ?>" maxlength="500"> </div>
			<div class="regCont" id="termsCont"><span class="heading" id="termsHead">Terms and Conditions</span> <input type="checkbox" name="confirmedTerms" value="yes"> I have read the terms and conditions </div>
			<div class="regCont" id="submitCont">
				<input type="submit" name="submit" value="Submit" id="submitButton">
			</div>
		</form>
		
		<?php
			if (isset($_POST['submit'])) {
				register();
				// Reset Post
				$_POST = array();
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
