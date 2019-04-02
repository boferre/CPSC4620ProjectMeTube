<?php
	function search($keyword) {
		echo "<meta http-equiv='refresh' content='0;url=http://webapp.cs.clemson.edu/~boferre/metube/browse.php?searched=$keyword' />";
	}
	
	
	function displayResults($data, $type) {
		echo "<span id='Header'>Searching for $data</span><br>";
		echo "<span id='Header'>Here is what we found!</span><br>";
		echo "<br><span id='Header'>Results that matched Accounts</span><br>";
		displayList('', $data, 0, 3);
		echo "<div id='titleResultCont'><br><span id='Header'>Results that matched keywords</span><br></div>";
		displayList('', $data, 0, 4);
		echo "<div id='titleResultCont'><br><span id='Header'>Results that matched Title</span><br></div>";
		displayList('', $data, 0, 2);
		
	
	}

?>