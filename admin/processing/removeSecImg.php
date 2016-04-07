<?php
	include '../../db.php';	
	$img_id = $_POST['img_id'];
	$img_type = $_POST['type'];



	// remove the secondary image

	// 
	// getting the image to remove it from the directory
	// 	

	if ($img_type == "secondary") {
	$sql = "SELECT * FROM imgs_ref WHERE img_id = '$img_id'";
	$query = $db->query($sql);
	if ($query) {
		while ($row = $query->fetch_assoc()) {
			$img = $row['img_path'];
		}
	}

	$primaryDirHandle = $_SERVER['DOCUMENT_ROOT']."/images/uploads/product_imgs/";
	$deleteDir = $primaryDirHandle.$img;
	if (file_exists($deleteDir)) {
		unlink($deleteDir);
	}
	
	
	$sql = "DELETE FROM imgs_ref WHERE img_id = '$img_id'";
	$query = $db->query($sql);

	if ($query) {
		$response = "Sucessfully Deleted";
	}
	else {
		$response = $db->error;
	}

	print $response;
	}
	else {
		// deleting the current primary image
		$sql = "SELECT img FROM products WHERE product_code = '$img_id'";
		$query = $db->query($sql);
		if ($query) {
			while ($row = $query->fetch_assoc()) {
				$img = $row['img'];
			}
		}
		$primaryDirHandle = $_SERVER['DOCUMENT_ROOT']."/images/products/";
		$deleteDir = $primaryDirHandle.$img;
		if (file_exists($deleteDir)) {
				unlink($deleteDir);
		}
		$response = "Sucessfully Deleted";
		print $response;
	}



?>
