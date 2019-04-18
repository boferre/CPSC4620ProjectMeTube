<?php
	include 'accountManagementFunctions.php';
	session_start();
	if (isset($_SESSION['accountID'])) {
		$acc = $_SESSION['accountID'];
		$ListID = $_GET['list'];
		$mediaID = $_GET['media'];
		addToPlaylist($acc, $mediaID, $ListID);
	}
	
	header("Location: {$_SERVER['HTTP_REFERER']}");
?>