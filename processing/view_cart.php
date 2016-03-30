<?php
	session_start();
	$session = $_SESSION['session_id'];
	$response = "";
	include '../db.php';
	$action = $_POST['action'];

	if ($action == "update" || $action == "updateQty") {
	if (!isset($_POST['qty'], $_POST['product_id']) || $_POST['qty'] < 0 || !is_numeric($_POST['qty'])) {
		$response .= "Please enter a valid value";
	}
	else {
		$qty = $_POST['qty'];
		$product_id = $_POST['product_id'];
		
		
		$sql = "UPDATE cart SET qty = '$qty' WHERE product_id = '$product_id' AND session_id = '$session'";
		$query = $db->query($sql);

		if ($query) {
			$response.= "Successfully Updated";
		}
		else {
			$response.= "Something went wrong! $db->error";
		  }
		}
	}
	if ($action == "updateSize") {
		$size = $_POST['size'];
		$product_id = $_POST['product_id'];

		$sql = "UPDATE cart SET size = '$size' WHERE product_id = '$product_id'";
		$query = $db->query($sql);
		if ($query) {
			$response = "Item Successfully updated";
		}
	}
	if ($action == "remove") {
		if (!isset($_POST['product_id'])) {
			$response .= "Something went wrong";
		}
		else {
			$product_id = $_POST['product_id'];

			include '../db.php';
			$sql = "DELETE from cart WHERE product_id = '$product_id' AND session_id = '$session'";
			$query = $db->query($sql);

			if ($query) {
				$response .= "Successfully deleted";
			}
			else {
				$response .= "Something went wrong $db->error";
			}
		}
	}

	print $response;
?>