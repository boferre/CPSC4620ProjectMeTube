<?php
	include 'server.php';
	session_start();
	
	if(isset($_SESSION['accountID'])) {
		$usr = $_SESSION['accountID'];
		$media = $_GET['media'];
		$sql = "SELECT link FROM media WHERE mediaID=$media;";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$file = "../". $row['link'];
		
		unlink($file) or die("Couldn't delete file");
		
		// Remove from media table
		$sql = "DELETE FROM media WHERE mediaID=$media;";
		$result = $conn->query($sql);
		
		// remove from comments table
		$sql = "DELETE FROM comments WHERE mediaID=$media;";
		$result = $conn->query($sql);
		
		// remove from playlist table
		$sql = "DELETE FROM playlistLinks WHERE mediaLink=$media;";
		$result = $conn->query($sql);
		
		header('Location: ' . $_SERVER['HTTP_REFERER']);

	
	} else {
		return;
	}
	
?>