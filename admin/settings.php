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
							<h4 class="light title">Settings</h4>
							<p class="identifier">Set things up?</p>
							<br/>
							<br/>
														<?php include('nav.php');?>
						</nav>
					</div>
				</div>
				<br/>

				<div id="settings">	
<h5 class="light title">Change Password:</h5>
					<form method="post" action="processing/changepass.php">
						<table>

				<tr><td><p>Current:</td><td> <input type="password" maxlength='20' name="currentpass" id="currentpass"/></p></td></tr>
				<tr><td><p>New:</td><td> <input type="password" maxlength='20' name="newpass" id="newpass"/></p></td></tr>
			<tr><td><p>Retype New:</td><td><input type="password" maxlength='20' name="rnewpass" id="rnewpass"/></p></td></tr>
<tr><td><input type="submit"/></td></tr>
				<input type="hidden" value="<?php print $form_token?>" name = "token" id="token">
				<tr>
				</table>
					<br/>	
					
					<?php
						/* $sql = "SELECT * FROM `{$db_name}`.`users`";
						$query = $db->query($sql);

						if ($query->num_rows > 0) {
							print "
								<p><h6>Administrators</h6></p><br>
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
	*/				?>


				</div>

			</div>
		</div>
	</section>
</body>
</html>
