<?php
session_start();
$errcntr = 0;
$response = "";
if (!isset($_SESSION['login_token'])) {
	print "<div class='globalerror'>
            <div class='errorglobalcontent'>
            <div class='errorlogo'><p> < / error ... > </p></div>
            <br/>
            <h4>You do not have the permission to view this page</h4><br/>
            <p>You better go back now!</p><br/>
            <p id='back'><a href='/store'>Back</a></p>
            </div>
            </div>";
	exit;
}

include '../../db.php';


if (!isset($_POST['name']) || !isset($_POST['desc']) || !isset($_POST['price']) || !isset($_POST['stock'])) {
	print "Fill out all the required fields in order to add an item";
	exit;
}
else {
	$name = $_POST['name'];
	$name = str_replace("'", "''", $name);
	$name = str_replace('"', '\"', $name);

	$desc = $_POST['desc'];
	$stock = $_POST['stock'];
	$price = $_POST['price'];
	$desc = str_replace("'", "''", $desc);
	$desc = str_replace('"', '\"', $desc);

	$cat = $_POST['cat'];
	$size = "Standard";

	if (isset($_POST['shoe_size'])) {
		$size = $_POST['shoe_size'];
	}
	elseif (isset($_POST['clothing_size'])) {
		$size = $_POST['clothing_size'];
	}

}

//
// UPLOADING DATA TO THE DATABSE // CREATING A NEW PRODUCT
//

$sql = "INSERT INTO products(name, description, price, stock) VALUES('$name', '$desc', '$price', '$stock')";
$query = $db->query($sql);


if ($query) {
	$last_id = $db->insert_id;
}
else {
	$response .= $db->error;
	print $response;
	$errcntr++;
	exit;
}


// figure out what is category of the product
// and the desired sizes.

if ($size == "Standard") {
		$cat = "No cat.";
		$sql = "INSERT INTO product_details(product_code, category, size) VALUES ('$last_id', '$cat', '$size')";
		$query = $db->query($sql);

}
else {
		foreach ($size as $size_Temp) {
		$sql = "INSERT INTO product_details(product_code, category, size) VALUES ('$last_id', '$cat', '$size_Temp')";
		$query = $db->query($sql);

	}
}



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



if ($uploadError) {
	print "<h3>Item Succesfully Added</h3>";
	print "<a href='/store/admin/'>GO BACK!</a>";
}
else {
	print $response;
}

?>
