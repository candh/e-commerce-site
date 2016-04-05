<?php
	session_start();
	if (!isset($_SESSION['login_token'])) {
		exit;
	}
	$response = "";
	include '../../db.php';

	if (!isset($_POST['order_id']) || !isset( $_POST['customer_id'])) {
		$response .= "Something went wrong with the data";
		exit;
	}
	else {
		$order_id = $_POST['order_id'];
		$customer_id = $_POST['customer_id'];
	}



	$sql = "DELETE FROM orders WHERE order_id = '$order_id';"
    . "DELETE FROM order_details WHERE order_id = '$order_id'";
	$query = $db->multi_query($sql);
	if ($query) {
		$response .= "It's done";
	}
	else {
		$response .= $db->error;
	}

	$sql = "DELETE FROM customers WHERE customer_id = '$customer_id'";
	$query = $db->query($sql);
	if ($query) {
		$response .="It's done";
	}

	print $response;

?>
