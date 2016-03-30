<?php
	include '../db.php';
	$root  = $_SERVER['DOCUMENT_ROOT'];
	for ($i=1; $i <= 17; $i++) { 
		$v = 1;
		$sql  = "UPDATE products SET img = '$i.jpg' WHERE product_code = '$i'";
		$query = $db->query($sql);
		if ($query) {
			print "Added <br/>";
		}
		else {
			print "Something went wrong! $db->error";
		}
	}
?>