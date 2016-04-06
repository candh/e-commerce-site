<?php
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
			<p id='back'><a href='/'>Back</a></p>
			</div>
			</div>";
			exit;
	}
	?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Items</title>
</head>
<body>
	<section id="dashboard-super-wrapper">
	<div class="container">
		<div class="row">
			<div class="twelve candh">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Add / Remove Items</h4>
							<p class="identifier">Yeah..</p>
							<br/>
							<br/>
							<div class="navigation">
							<ul>
							<a href='index.php' ><li >Store</li></a>
							<a href='customers.php'><li>Customers</li></a>
							<a href='additems.php'><li class="activeLink">Add Item / Remove</li></a>
							<a href="update.php"><li>Update Item</li></a>
							<a href="inventory.php"><li>Inventory</li></a>
							<a href="logout.php"><li>Log Out</li></a>
							</ul>
							</div>
						</nav>
					</div>

					<!-- the content -->
					<br/>
					<div id="submission">
					<h5>Add an item :</h5>
					<br/>
					<form method="post" action="processing/add.php" id="upload" enctype="multipart/form-data">
						<p>Name :</p>
						<input type="text" name="name" id="name" maxlength="20">

						<p>Description :</p>
						<br/>
						<textarea name="desc" cols="50" rows="10" id="desc"></textarea>
						<br/>

						<div class="category">
						<p>Category : </p>
						<select name="cat" id="cat">
							<option value="">-</option>
							<option value="Shoes">Shoes</option>
							<option value="Clothing">Clothing</option>
						</select>
						
						<br/>

							<div class="sizeChoser">
								<div id="shoeSize">
								
									5<input name="shoe_size[]" type="checkbox" value="5">
									5.5<input name="shoe_size[]" type="checkbox" value="5.5">
									6<input name="shoe_size[]" type="checkbox" value="6">
									6.5<input name="shoe_size[]" type="checkbox" value="6.5">
									7<input name="shoe_size[]" type="checkbox" value="7">
									7.5<input name="shoe_size[]" type="checkbox" value="7.5">
									8<input name="shoe_size[]" type="checkbox" value="8">
									8.5<input name="shoe_size[]" type="checkbox" value="8.5">
									9<input name="shoe_size[]" type="checkbox" value="9">
									9.5<input name="shoe_size[]" type="checkbox" value="9.5">
									10<input name="shoe_size[]" type="checkbox" value="10">
									11<input name="shoe_size[]" type="checkbox" value="11">
								</div>

								<div id="clothingSize">
									S<input name="clothing_size[]" type="checkbox" value="S">
									M<input name="clothing_size[]" type="checkbox" value="M">
									L<input name="clothing_size[]" type="checkbox" value="L">
									XL<input name="clothing_size[]" type="checkbox" value="XL">
								</div>
								<br/>

							</div>
						
						</div>


						<p>In Stock : </p>
						<input type="text" name="stock" id="stock">

						<p>Price : </p>
						<input type="text" name="price" id="price">
					

						<p>Select Images :<p>
						<input type="file" name="files[]" multiple='multiple'>
						<input type="hidden" name="submitSec">
						<br/>

						<div class="errorAdd"></div>
						<input type="submit" value="Upload" name="submit">

					</form>
					</div>

					<br/>
					<hr>
					<br/>
					<form method="post" action="processing/remove.php" class="removeItem">
					<h5>Remove an item :</h5>
					<br/>
						<p>Enter the product Id of the product which you want to remove :</p>
						<input type="text" name="product_id" id="product_id">
						<div class="error"></div>
						<input type="submit" name="remove" id="remove" value="Remove">
					</form>
					<!-- /the content -->
				</div>
			</div>
		</div>
		</div>
	</section>


<!-- modal window for the removing of items -->

		<div id="remove_item_wrapper">
			<div class="closer_modal">
				<i class='fa fa-close fa-2x'></i>
			</div>
			<div class="remove_item_content">
				<div class="confirm_remove"></div>
			</div>
		</div>

<!-- /  modal window for the removing of items -->

<!-- warning -->


<!-- / end warning -->
</body>
</html>
