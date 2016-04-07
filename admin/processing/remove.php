<?php
session_start();
$response = "";
include '../../db.php';

$action = "";
$product_id = $_POST['product_id'];
if (isset($_POST['confirm_delete'])) {
	$action = $_POST['confirm_delete'];
}
else {
	$action = $_POST['remove'];
}
if (isset($_POST['product_id'])) {
	$product_id = $_POST['product_id'];
}
	

if ($action == "Remove") {
	# code...

$sql = "SELECT * FROM products WHERE product_code = '$product_id'";
$query = $db->query($sql);

if ($query->num_rows > 0) {
	while ($row = $query->fetch_assoc()) {
		$product_code = $row['product_code'];
		$name = $row['name'];
		$price = $row['price'];
		$img = $row['img'];

		$response .="<table border='1'>
		<tr>
			<th>Product Code</th>
			<th>Product</th>
			<th>Name</th>
			<th>Price</th>
		</tr>

		<tr>
			<td>$product_code</td>
			<td><img src='/images/products/$img'></td>
			<td>$name</td>
			<td>$$price</td>
		</tr>
		</table>
		<br/>
				<br/>
				
				<form action='processing/remove.php' method='post' class='confirmRemoveItem'>
					<input type='hidden' name='product_id' value='$product_code'>
					<input type='submit' name='confirm_delete' id='confirm_delete' value='Confirm Remove'>
				</form>
		";

	}
}
else {
	$response .= "Sorry, no product found with this Id";
}


}
if ($action == "Confirm Remove") {

		$sql = "SELECT img FROM products WHERE product_code = '$product_id'";
		$query = $db->query($sql);
		if ($query) {
			while ($row = $query->fetch_assoc()) {
				$img = $row['img'];
			}
		}



			$primaryDirHandle = $_SERVER['DOCUMENT_ROOT']."/images/products/";
			// deleting the current primary image
			$deleteDir = $primaryDirHandle.$img;
			if (file_exists($deleteDir)) {
				unlink($deleteDir);
			}
			

	$sql = "DELETE FROM products WHERE product_code = '$product_id'";
	$query = $db->query($sql);

	if ($query) {
		$response .= "Successfully deleted";

		$sql = "SELECT * FROM imgs_ref WHERE product_code = '$product_id'";
		$query = $db->query($sql);
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$tmp_img_path = $row['img_path'];


				$primaryDirHandle = $_SERVER['DOCUMENT_ROOT']."/images/uploads/product_imgs/";
				// deleting the secondary image from the machine
				$deleteDir = $primaryDirHandle.$tmp_img_path;
				unlink($deleteDir);

			}
		}

		$sql = "DELETE FROM imgs_ref WHERE product_code = '$product_id'";
		$query = $db->query($sql);
	}
}




print $response;
?>
