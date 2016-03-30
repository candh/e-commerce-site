<?php
	session_start();
	$session = $_SESSION['session_id'];

	$response = "";

	if (!isset($_POST['qty']) || !is_numeric($_POST['qty'])) {
		$response .= "Please enter a valid quantity";
		print $response;
		exit;
	}
	elseif (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
		$response .= "Invalid Form Submission";
		print $response;
		exit;
	}
	else {
		$product_id = $_POST['product_id'];
		$qty = $_POST['qty'];
		$action = $_POST['submit'];
		if (isset($_POST['size'])) {
			$size = $_POST['size'];
		}
		else {
			$size = "Standard";
		}
		
	}

	// 
	// CONECTION TO THE DB.PHP
	// 

		include '../db.php';

	// 
	// ADDING TO THE CART
	// 

	if ($action == "Add to Cart") {


	$sql = "INSERT INTO cart (session_id, product_id, qty, size) VALUES ('$session', '$product_id', '$qty', '$size')";
	$query = $db->query($sql);
	if ($query) {
		$response .= "Successfully Added to Cart";
	}
	else {
		$response .= "Something went wrong while adding to the cart $db->error";
	}

	}
	elseif ($action == "Update Cart") {

		if ($qty > 0) {
		$sql = "UPDATE cart SET qty = '$qty', size = '$size' WHERE product_id = '$product_id' AND session_id = '$session'";
		$query = $db->query($sql);

		if ($query) {
			$response .= "Successfully Updated";
		}
		else {
			$response .= "Something went wrong!";
		}
		}
		else {
			$sql = "DELETE FROM cart WHERE session_id = '$session' AND product_id = '$product_id'";
			$query = $db->query($sql);
			if ($query) {
				$response .= "Successfully Deleted";
			}
			else {
				$response .= "Something went wrong!";
			}
		}

	}

	print $response;
?>