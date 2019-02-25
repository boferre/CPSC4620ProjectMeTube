<!DOCTYPE html>

<head>
	<link rel="stylesheet" type="text/css" href="css/template.css" />
	<link rel="stylesheet" type="text/css" href="css/register.css" />
	<title>MeTube - Registration</title>
	<link rel="icon" href="" />
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
</head>

<?php
	$accountID = 0;
	$username = '';
	$displayname = '';
	$Fname = '';
	$Lname = '';
	$secquestion = 0;
	$secanswer = '';
?>


<html id="webPage">
<div id="container">
	<header id="headCont">
		<div id="headData">
			<span id="logoCont"><a href="index.php">logo</a></span>
			<span id="searchCont"> <input type="text" id="searchBar"  name="searchVal"><button type="button">Search</button></span>  
			<a id="menuCont" href="register.php">Register</a> <a id="menuCont" href="upload.php">Upload</a>
		</div>
	</header>
<body>
	<div id="mainPageContent">
		<div class="regTitle" id="titleCont">Fill out the following information to register!</div>
		<div id="infoCont">
		
			<div class="regCont" id="fullNameCont"><span class="heading" id="nameHead">Full Name</span> <input type="text" id="nameInput" name="fName"> <input type="text" id="nameInput" name="lName"></div>
			<div class="regCont" id="emailCont"><span class="heading" id="emailHead">Email</span> <input type="text" id="emailInput" name="email"></div>
			<div class="regCont" id="accName"><span class="heading" id="displayHead">Display Name</span> <input type="text" id="nameInput" name="dName"></div>
			<div class="regCont" id="passCont"><span class="heading" id="passHead">Password</span> <input type="text" id="passInput" name="password"> <input type="text" id="passInput" name="passwordComp"></div>
			<div class="regCont" id="secQueCont"><span class="heading" id="secHead">Security Question</span> 
				<select>
				  <option value="1">Question 1</option>
				  <option value="2">Question 2</option>
				  <option value="3">Question 3</option>
				  <option value="4">Question 4</option>
				</select> <input type="text" id="secAnInput" name="secAnswer"> </div>
			<div class="regCont" id="termsCont"><span class="heading" id="termsHead">Terms and Conditions</span> <input type="checkbox" name="confirmedTerms" value="yes"> I have read the terms and conditions </div>
			<div class="regCont" id="submitCont"><button type="button" id="submitButton">Submit</button></div>
		
		</div>
	</div>
</body>
	<footer id="footCont">
		other links and information
	</footer>
</div>
</html>
