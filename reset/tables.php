<?php
// the products table
$server = "localhost";
$username = "root";
$pswd = "";
$db_name = "store";

$db = new mysqli($server, $username, $pswd, $db_name);
if ($db) {
	print "connection successful<br/>";
}
else {
	die("It doesn't work. Please check your connection parameters $db->error");
}

// the products table 

$sql = "CREATE TABLE products(
		product_code int(11) PRIMARY KEY AUTO_INCREMENT,
		name varchar(40),
		description text,
		price varchar(100),
		img varchar(100),
		stock int(11),
		sold int(11)
		)";

$query = $db->query($sql);
if ($query) {
	print "[PRODUCTS] WAS CREATED<br/>";
}
else {
	print "$db->error";
}

// the customers table

$sql = "CREATE TABLE customers (
		customer_id int(11) PRIMARY KEY AUTO_INCREMENT,
		session_id varchar(100),
		first_name varchar(40),
		last_name varchar(50),
		address_1 varchar(50),
		address_2 varchar(50),
		city varchar(40),
		state varchar(40),
		zip_code varchar(15),
		phone varchar(40),
		email varchar(40)
		)";

$query = $db->query($sql);
if ($query) {
	print "[CUSTOMERS] WAS CREATED<br/>";
}
else {
	print "$db->error";
}

// the orders table

$sql = "CREATE TABLE orders (
		order_id int(11) PRIMARY KEY AUTO_INCREMENT,
		order_date DATE,
		customer_id int(11),
		cost_subtotal dec(6,2),
		shipping_subtotal dec(6,2),
		cost_tax dec(6,2),
		cost_total dec(6,2),
		shipping_first_name VARCHAR(20),
		shipping_last_name  VARCHAR(20),
		shipping_address_1  VARCHAR(50),
		shipping_address_2  VARCHAR(50),
		shipping_city       VARCHAR(20),
		shipping_state      VARCHAR(20),
		shipping_zipcode   VARCHAR(20),
		shipping_phone      VARCHAR(40),
		shipping_email      VARCHAR(100)
		)";
$query = $db->query($sql);
if ($query) {
	print "[ORDERS] WAS CREATED<br/>";
}
else {
	print "$db->error";
}

// the order_details table

$sql = "CREATE TABLE IF NOT EXISTS order_details (
	order_id int(11) NOT NULL,
	order_qty int(11) NOT NULL,
	product_id int(11) NOT NULL
	)";
$query = $db->query($sql);
if ($query) {
	print "[ORDER_DETAILS] WAS CREATED <br/>";
}
else {
	print "$db->error";
}

// the temporary cart

$sql = "CREATE TABLE cart (
	session_id  varchar(100),
	product_id int(11),
	qty int(11)
	)";
$query = $db->query($sql);
if ($query) {
	print "[CART] WAS CREATED <br/>";
}
else {
	print "$db->error";
}

?>