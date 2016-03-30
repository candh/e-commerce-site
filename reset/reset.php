<?php
	include '../db.php';

	$sql = "TRUNCATE TABLE order_details;";
	$sql .= "TRUNCATE TABLE cart;";
	$sql .= "TRUNCATE TABLE customers;";
	$sql .= "TRUNCATE TABLE orders;";
	$sql .= "TRUNCATE TABLE products;";
	$sql .= "TRUNCATE TABLE imgs_ref;";
	$sql .= "TRUNCATE TABLE product_details;";
	$query = $db->multi_query($sql);

	if ($query) {
		print "EVERYTHING IS RESET";
	}
	print $db->error;
?>