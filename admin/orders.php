<!DOCTYPE html>
<html>
<head>
	<title>Order Processing</title>
	<?php
	session_start();
	include 'db.php';
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
	?>
</head>
<body>
	<section id="dashboard-super-wrapper">
		<div class="container">
		<div class="row">
			<div class="twelve">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Orders</h4>
							<p class="identifier">The orders placed on the site</p>
							<br/>
							<br/>
							<div class="navigation">
							<ul>
							<a href='index.php' ><li class="activeLink" >Store</li></a>
							<a href='customers.php'><li>Customers</li></a>
							<a href='additems.php'><li>Add Item / Remove</li></a>
							<a href="update.php"><li>Update Item</li></a>
							<a href="inventory.php"><li>Inventory</li></a>
							<a href="logout.php"><li>Log Out</li></a>
							</ul>
							</div>
						</nav>
					</div>

			</div>
		</div>
		</div>	

				<div class="tableContainer">
					<!-- the content -->
					<h5>Customer Information : </h5>
					<br/>
					<table border="1">
						<tr>
							<th>Customer Id</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Address 1</th>
							<th>Address 2</th>
							<th>City</th>
							<th>State</th>
							<th>Zip Code</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Time-stamp</th>
						</tr>

						
						<?php
							$cntr = 1;
							$customerId = $_GET['id'];

							$sql = "SELECT * FROM customers, orders WHERE customers.customer_id = '$customerId' AND orders.customer_id = '$customerId'";
							$query = $db->query($sql);
							if ($query->num_rows > 0) {
								while ($row = $query->fetch_assoc()) {
									$customer_id = $row['customer_id'];
									$firstname = $row['first_name'];
									$lastname = $row['last_name'];
									$address1 = $row['address_1'];
									$address2 = $row['address_2'];
									$city = $row['city'];
									$state = $row['state'];
									$zipcode = $row['zip_code'];
									$email = $row['email'];
									$phone = $row['phone'];
									$time = $row['order_date'];


																$remain = $cntr % 2;
						if ($remain == 0) {
							$style = "style='background-color:#D9D9D9;'";
						}
						else {
							$style = "style='background-color:#FFFFFF;'";
						}

							print "<tr $style>
								   <td>$customer_id</td></a>
								   <td>$firstname</td>
								   <td>$lastname</td>
								   <td>$address1</td>
								   <td>$address2</td>
								   <td>$city</td>
								   <td>$state</td>
								   <td>$zipcode</td>
								   <td>$phone</td>
								   <td>$email</td>
								   <td>$time</td>
								   </tr>
								   ";
								}
							}
							else {
								print "<h4 class='warning'>No customer found with this Id</h4>";
								exit;
							}
							 $cntr++;
						?>
						
					</table>

					<br/>
					<br/>

					<h5>What the customer ordered : </h5>
					<br/>
					<table border = 1>
						<tr>
							<th>Customer Id</th>
							<th>Order Id</th>
							<th>Product Name</th>
							<th>Product Code</th>
							<th>Product Qty</th>
							<th>Size</th>
							<th>Price</th>

						</tr>

					<?php
						$cntr2 = 1;
						$sql = "SELECT * FROM products, orders JOIN order_details ON order_details.order_id = orders.order_id WHERE order_details.product_id = products.product_code AND orders.customer_id = '$customer_id'";
						$query = $db->query($sql);
						if ($query->num_rows > 0) {
							while ($row = $query->fetch_assoc()) {
								$customer_id = $row['customer_id'];
								$order_id = $row['order_id'];
								$name = $row['name'];
								$product_code = $row['product_code'];
								$order_qty = $row['order_qty'];
								$price = $row['price'];
								$size = $row['size'];

						$remain = $cntr2 % 2;
						if ($remain == 0) {
							$style = "style='background-color:#D9D9D9;'";
						}
						else {
							$style = "style='background-color:#FFFFFF;'";
						}
							print "	<tr $style>
									<td>$customer_id</td>
									<td>$order_id</td>
									<td>$name</td>
									<td>$product_code</td>
									<td>$order_qty</td>
									<td>$size</td>
									<td>$$price</td>
									</tr>";	

									$cntr2++;
							}
						}
						else {

						}
						
					?>
					</table>


					<br/>
					<br/>

					<h5>Customer Credit :</h6>
					<br/>
					<table border="1">
						<tr>
							<th>Subtotal</th>
							<th>Shipping</th>
							<th>Tax</th>
							<th>Total</th>
						</tr>

					<?php
					$cntr3 = 1;
					$sql = "SELECT cost_subtotal, shipping_subtotal, cost_tax, cost_total FROM orders WHERE order_id = '$order_id'";
					$query = $db->query($sql);
					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$subtotal = $row['cost_subtotal'];
							$shipping_subtotal = $row['shipping_subtotal'];
							$tax = $row['cost_tax'];
							$total = $row['cost_total'];
						$remain = $cntr3 % 2;
						if ($remain == 0) {
							$style = "style='background-color:#D9D9D9;'";
						}
						else {
							$style = "style='background-color:#FFFFFF;'";
						}
							print "<tr $style>
								<td>$$subtotal</td>
								<td>$$shipping_subtotal</td>
								<td>$$tax</td>
								<td>$$total</td>
							</tr>";
						}
					}
					$cntr3++;
					?>
					</table>
					<!-- /the content -->

					<form action="processing/process.php" method="post" class="process">
					<br/>
					<br/>
						<input type="hidden" value="<?php print $order_id?>" id="order_id">
						<input type="hidden" value="<?php print $customerId?>" id="customer_id">
						<input type="submit" value="Processed">
					</form>

					<br/>
					<br/>
					<br/>
					<br/>
					<br/>
			</div>

	</section>


<div id="alert">
	<div class="alertcontent">
		<h5></h5>
	</div>
</div>
</body>
</html>