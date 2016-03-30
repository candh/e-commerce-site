<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
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
			<div class="twelve candh">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Customers</h4>
							<p class="identifier">Process the customer's order here</p>
							<br/>
							<br/>
							<div class="navigation">
							<ul>
							<a href='index.php' ><li  >Store</li></a>
							<a href='customers.php'><li class="activeLink">Customers</li></a>
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
					<!-- the content -->
					<div class="tableContainer">
					<br/>
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
							<th>Process</th>
						</tr>
						<?php
							$cntr = 1;
							$sql = "SELECT *, orders.order_date FROM customers, orders WHERE customers.customer_id = orders.customer_id ORDER by customers.customer_id DESC";
							$query = $db->query($sql);
							if ($query->num_rows > 0) {
								while ($row = $query->fetch_assoc()) {
									$customerId = $row['customer_id'];
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
								   <td>$customerId</td></a>
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
								   <td class='process'><a href='orders.php?id=$customerId'>PROCESS!</a></td>
								   </tr>";

								   $cntr++;
								}
							}
						?>
						
					</table>
				</div>
					<!-- /the content -->
	
	</section>
</body>
</html>