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
	<title>Admin :: Dashboard</title>

</head>
<body>
	<section id='dashboard_wrapper'>
		<div class="container">
			<div class="row">
				<div class="twelve candh">
					<div class="dashboard-nav-wrapper">
						<nav>
							<h4 class="light title">Dashboard</h4>
							<p class="identifier">Welcome, admin</p>
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


			<div class="facts">
				<table border="1">
					<tr>
						<th>Total Orders</th>
						<th>Total Products</th>
					</tr>

										
					<?php
						$cntr = 1;
						$remain = $cntr % 2;
						if ($remain == 0) {
							$style = "style='background-color:#D9D9D9;'";
						}
						else {
							$style = "style='background-color:#FFFFFF;'";
						}

						print "<tr $style>";
						
						$sql = "SELECT COUNT(order_id) FROM orders";
						$query = $db->query($sql);
						if ($query->num_rows > 0) {
							while ($row = $query->fetch_array()) {
								$total_orders = $row['0'];
							}
						}
						else {
							$total_orders = 0;
						}

						print "<td>$total_orders</td>";


						$sql = "SELECT COUNT(product_code) FROM products";
						$query = $db->query($sql);
						if ($query->num_rows > 0) {
							while ($row = $query->fetch_array()) {
								$total_products = $row['0'];
							}
						}
						else {
							$total_products = 0;
						}

						print "<td>$total_products</td>";
						$cntr++;
					?>
					</tr>

			    </table>

					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
