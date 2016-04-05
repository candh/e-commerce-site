<?php
		
		include '../../db.php';

		$response = "";
		if (isset($_POST['product_id'])) {
		$id = $_POST['product_id'];
		$stock = $_POST['stock'];

		$sql = "UPDATE products SET stock = '$stock' WHERE product_code = '$id'";
		$query = $db->query($sql);
		if (!$query) {
			$response .= $db->error;
		}
		else {
			$response  .= 'Updated';
		}
	}

	print $response;
?>
