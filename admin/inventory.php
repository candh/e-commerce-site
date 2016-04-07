<?php
	session_start();
	include '../db.php';
	include 'styles.html';
	$response = "";
	if (!isset($_SESSION['login_token'])) {
		print "<div class='globalerror'>
			<div class='errorglobalcontent'>
			<div class='errorlogo'><p> < / error ... > </p></div>
			<br/>
			<h4>You do not have the permission to view this page</h4><br/>
			<p>You better go back now!</p><br/>
			<p id='back'><a href='..'>Back</a></p>
			</div>
			</div>";
			exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin :: Dashboard</title></head>
<body>
	<section id='dashboard_wrapper'>
		<div class="container">
			<div class="row">
				<div class="twelve candh">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Inventory</h4>
							<p class="identifier">View the items in your inventory</p>
							<br/>
							<br/>
							<div class="navigation">
							<ul>
							<a href='index.php' ><li >Store</li></a>
							<a href='customers.php'><li>Customers</li></a>
							<a href='additems.php'><li>Add Item / Remove</li></a>
							<a href="update.php"><li>Update Item</li></a>
							<a href="inventory.php"><li class="activeLink" >Inventory</li></a>
							<a href="logout.php"><li>Log Out</li></a>
							</ul>
							</div>
						</nav>
					</div>
				</div>
				<br/>

				<div id="inventory">	
					
					<br/>	
					
					<?php
						$sql = "SELECT * FROM `{$db_name}`.`products` WHERE `stock` = '1'";
						$query = $db->query($sql);

						if ($query->num_rows > 0) {
							print "
								<p><h6>Items that are out of stock</h6></p><br>
									<table border='1'>
										<tr>
											<th>Product Code</th>
											<th>Product</th>
											<th>In Stock</th>
											<th>Update</th>
										</tr>
									";

							while ($row = $query->fetch_assoc()) {
								$product_code = $row['product_code'];
								$product_img = $row['img'];
								$price = $row['price'];
								$stock = $row['stock'];

								print "<tr'>
								<td>$product_code</td>
								<td><img src='../images/products/$product_img'></td>
								<form action='' method='post' class='updateInventory' id='$product_code'>
								<td><input type = 'text' maxlength='8' name='stock' id='stock_$product_code' value='$stock'></td>
								<td id='status_$product_code'>
									<input type ='submit' value='Update'>
									<input type = 'hidden' value='$product_code' name='product_id'>
								</form>
								</td>
								</tr>";
							}

							print "</table>";
						}
						else {
							print"<div class='text-center'><h6>Everything's looking good!</h6>
								 <p>Good Job. No item is out of stock</p></div>";
						}
					?>


				</div>

			</div>
		</div>
	</section>
</body>
</html>
