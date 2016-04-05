<?php
	$response = "";
	session_start();
	include '../db.php';
	include 'styles.html';

	if (!isset($_SESSION['login_token'])) {
		print "<div class='globalerror'>
			<div class='errorglobalcontent'>
			<div class='errorlogo'><p> < / error ... > </p></div>
			<br/>
			<h4>You do not have the permission to view this page</h4><br/>
			<p>You better go back now!</p><br/>
			<p id='back'><a href='http://localhost/store/'>Back</a></p>
			</div>
			</div>";
			exit;
	}	
	// GETTING THE PRODUCT 
	if (isset($_POST['product_id']) && isset($_POST['id_query'])) {
		$product_id = $_POST['product_id'];
		$sql = "SELECT * FROM products WHERE product_code = '$product_id'";
		$query = $db->query($sql);

		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$id = $row['product_code'];
				$name = $row['name'];
				$desc = $row['description'];
				$price = $row['price'];
				$img = $row['img'];
				$stock = $row['stock'];
			}
		}
		else {
			$response .="<div style='margin:50px;'><h4>No items with this ID</h4>
						<a href='/store/admin/update.php'>Go Back</a></div>";
			print $response;
			exit;
		}
	}


	if (isset($_POST['updateItem'])) {
		$product_id = $_POST['product_id'];
		// 
		// getting the data
		// 
		$product_id = $_POST['product_id'];
		$name = $_POST['name'];

		$name = str_replace("'", "''", $name);
		$name = str_replace('"', '\"', $name);


		$desc = $_POST['desc'];
		// sanitize the data
		$desc = str_replace("'", "''", $desc);
		$desc = str_replace('"', '\"', $desc);

		$price = $_POST['price'];
		$stock = $_POST['stock'];


		$sql = "UPDATE products SET name = '$name', description = '$desc', price = '$price', stock = '$stock' WHERE product_code = '$product_id'";
		$query = $db->query($sql);
		if ($query) {
			$response = "<div style='color:#D45656'>Item was updated</div><br/> <br/>";
		}
		else {
			$response = "Something went wrong while updating the item $db->error";
		}


		$last_id = $product_id;

		// uploading images
		// uploading images
		// ===============================================================================
// I M A G E   U P L O A D
//  ===============================================================================

	$uploadError = true;

	// the directories 
	$primaryDir = $_SERVER['DOCUMENT_ROOT']."store/images/products/";
	$secondaryDir = $_SERVER['DOCUMENT_ROOT'].'store/images/uploads/product_imgs/';

	// the max file size 
	$maxfilesize = 5000000;

	// the global variables for image upload
	$totalImages = 0;

	foreach ($_FILES['files']['name'] as $index => $name) {
		// check if the image(s) are EVEN uploaded
		if(is_uploaded_file($_FILES['files']['tmp_name'][$index])){
			// the first image as the primary IMG
			if ($index == 0) {
				// deal with the first image

				// build up its name
				$primaryImg = $last_id.$name;
				$primaryImg = strtolower($primaryImg);
				$primaryImg = preg_replace("/[^A-Z0-9._-]/i", "_", $primaryImg);
				$primaryTargetFile = $primaryDir.basename($primaryImg);

				$imgfiletype = pathinfo($primaryTargetFile, PATHINFO_EXTENSION);

				// the required checks
				$check = getimagesize($_FILES['files']['tmp_name'][$index]);
				if ($check !== false) {
					$uploadOk = 1;
				}
				else {
					$uploadOk = 0;
					$response = "Don't mess with the site";
					print $response;
					exit;
				}
				// check file size
				if ($_FILES['files']['size'][$index] > $maxfilesize) {
					$uploadOk = 0;
					$response = "Sorry, your uploaded file is too large";
					print $response;
					exit;
				}
				// Allow certain file formats
				if ($imgfiletype != "jpg" && $imgfiletype != "png" && $imgfiletype != "PNG" && $imgfiletype != "jpeg" && $imgfiletype != "gif") {
					$response .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
					print $response;
					$errcntr++;
					exit;
				}

				if ($uploadOk == 0) {
					$response = "Sorry, your file was not uploaded";
					print $response;
					exit;
				}
				else {
					if (move_uploaded_file($_FILES['files']['tmp_name'][$index], $primaryTargetFile)) {
						$sql = "UPDATE products SET img = '$primaryImg' WHERE product_code = '$last_id'";
						$query = $db->query($sql);
						if (!$query) {
							print $db->error;
							exit;
						}
					}
					else {
						$response = "Sorry, there was a error uploading your file";
						print $response;
						exit;
					}
				}
			}
			else {
				// continue with the secondary images


				// building up its name
				$secondaryImg = $last_id.$name;
				$secondaryImg = strtolower($secondaryImg);
				$secondaryImg = preg_replace("/[^A-Z0-9._-]/i", "_", $secondaryImg);
				$secondaryTargetFile = $secondaryDir.basename($secondaryImg);

				// it's file type
				$imgfiletype = pathinfo($secondaryTargetFile, PATHINFO_EXTENSION);
			
				// check to see the size of the file 
				if ($_FILES['files']['size'][$index] > $maxfilesize) {
					$response = "Sorry, the image is too big";
					print $response;
					exit;
				}
				elseif ($imgfiletype != "jpg" && $imgfiletype != "png" && $imgfiletype != "PNG" && $imgfiletype != "jpeg" && $imgfiletype != "gif") {
					$response .= "Don't fuck with the site";
					print $response;
					$errcntr++;
					exit;
				}
				else {
					// finally upload the image
					if(move_uploaded_file($_FILES['files']['tmp_name'][$index], $secondaryTargetFile)) {
					$sql = "INSERT INTO imgs_ref (product_code, img_path) VALUES('$last_id', '$secondaryImg')";
					$query = $db->query($sql);
						if (!$query) {
							print $db->error;
							exit;
						}
					}
					else {
						$response = "There was a error uploading your image";
						print $response;
						exit;
					}
				}
			}
		}
	}


	}


	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin :: Dashboard</title>
</head>
<body>
	<section id='dashboard_wrapper'>
		<div class="container">
			<div class="row">
				<div class="twelve candh">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Update Item</h4>
							<p class="identifier">Edit an item</p>
							<br/>
							<br/>
							<div class="navigation">
							<ul>
							<a href='index.php' ><li >Store</li></a>
							<a href='customers.php'><li>Customers</li></a>
							<a href='additems.php'><li>Add Item / Remove</li></a>
							<a href="update.php"><li class="activeLink" >Update Item</li></a>
							<a href="inventory.php"><li>Inventory</li></a>
							<a href="logout.php"><li>Log Out</li></a>
							</ul>
							</div>
						</nav>
					</div>

	 				<!-- the content -->

	 				<?php

	 					if (isset($response)) {
	 						print $response;
	 					}

	 					if (!isset($_POST['id_query'])) {
	 				?>
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
							<h5>Product Id ? :<h5>
							<input type="text" name="product_id" id="product_id">
							<input type="hidden" name="id_query" value="ok">
							<input type="submit" value="Submit">
						</form>
					<?php		

	 				}
	 				else {
	 				
	 				?>

					<!-- updated content -->
						<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post' enctype="multipart/form-data"  id='updateItem'>
							<p>
								Name : <br/>
								<input type="text" maxlength="20" name="name" id="name" value="<?php echo $name?>">
							</p>
							<br/>
							<p>
								Description : <br/><br/>
								<textarea name="desc" id='desc'><?php echo $desc?></textarea>
							</p>
							<br/>
							<p>
								Price : <br/>
								<input type="text" id="price" name="price" value="<?php echo $price?>">
							</p>	
							<br/>
							<p>
								In Stock : <br/>
								<input type="text" name="stock" id="stock" value="<?php echo $stock?>">
							</p>
							<br/>	
							
							<p>	Images : 
							<br/><br/>
								<table border="1">
									<tr>
										<td>Image</td>
										<td>Remove</td>	
									</tr>
									
									
										
									<?php
										$sql = "SELECT img, product_code FROM products WHERE product_code = '$id'";
										$query = $db->query($sql);
										if ($query->num_rows > 0) {
										
											while ($row = $query->fetch_assoc()) {
												$primaryImg = $row['img'];
												$primaryImgId = $row['product_code'];
												
												print "<tr id='primaryImg_$primaryImgId'>
												<td class='primaryImg'><img src='/store/images/products/$primaryImg'></td>
												<td><i class='fa fa-2x fa-close remove' data-type='primary' data-id='$primaryImgId'></i></td>
												</tr>";
											}
									
										}



										// for secondary images 
										$sql = "SELECT * FROM imgs_ref WHERE product_code = '$id'";
										$query = $db->query($sql);
										if ($query->num_rows > 0) {
											while ($row = $query->fetch_assoc()) {
												$secondaryImgId = $row['img_id'];
												$secondaryImgPath = $row['img_path'];

										print "<tr id='$secondaryImgId'>
											  <td class='secondaryImg'><img src='/store/images/uploads/product_imgs/$secondaryImgPath'></td>
											  <td><i class='fa fa-2x fa-close remove' data-type='secondary' data-id='$secondaryImgId'></i></td>
											  </tr>";
											}
										}
									?>

									
								</table>

								<br/>
								<input type="file" name="files[]" multiple='multiple'> 
							
							</p> 



							<div class="errorAdd"></div>
							<input type="hidden" name="product_id" value="<?php echo $id?>">
							<input type="hidden" name="updateItem" value="ok">
							<input type="submit" value="Update">
						</form>
						<br/>
							<div class="response" style="color:red;"></div>
							<br/>
							<br/>
							<br/>


					<?php
					
						}
					
					?>
				</div>
			</div>
		</div>
	</section>
	<br/>
	<br/>
	<br/>
	<br/>
</body>
</html>
