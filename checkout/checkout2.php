<?php
	include '../cssandjs.html';
	include '../functions.php';
	include '../db.php';
	session_start();



	if (isset($_SESSION['session_id'])) {
		$session = $_SESSION['session_id'];
	}
	else {
		print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! There's an error.</h5>
				<p>You must go back!</p><br/>
				<p class='back'><a href='/store/'>Go back</a></p>
				</div>
			  </div>";
		exit;
	}

	$errorfield = "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! Please fill the entire form.</h5>
				<p>You must go back!</p><br/>
				<p class='back'><a href='/store/checkout/1/'>Go back</a></p>
				</div>
			  </div>";
	$response = "";
	if (!isset($_POST['first_name'],$_POST['last_name'],$_POST['shipping_address'],$_POST['city'],$_POST['phone'])) {
		print $errorfield;
		exit;
	}
	else {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$shipping_address_1 = $_POST['shipping_address'];
		$shipping_address_2 = $_POST['shipping_address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipcode = $_POST['zip_code'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout Step 2</title>
</head>
<body>
<?php
	include '../elements/nav.php';
?>

<section id='checkout_super_wrapper_2'>
	<div class="row">
		<div class="eight candh push-by-two">
			<div class="checkout_wrapper_2">
				<div>
					<div id="heading-cta">
					<h4 class="light">Checkout Validation</h4>
					<p class="identifier"><b>Step 2</b></p>
					</div>
					<!-- the cart-preview -->
				
					<p>Please look carefully and validate the items in your cart and your shipping information. After submitting this, you won't be able to change the information</p>
					<br/>
					<br/>
					<h6>- Your items in the cart :</h6>	
				<div id="cart_items_table_wrapper" class="disabled_form">
				
					<table border="1">
						<tr>
							<th>Item</th>
							<th>Item Code</th>
							<th>Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Size</th>
							
						</tr>
					<?php
					$sql = "SELECT products.product_code, products.name, products.price, products.img, cart.size, cart.product_id, cart.qty FROM cart, products WHERE products.product_code = cart.product_id AND session_id = '$session'";
					$query = $db->query($sql);
					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$subtotal = 0;
							$item_code = $row['product_id'];
							$item_name = $row['name'];
							$item_price = $row['price'];
							$item_qty = $row['qty'];
							$item_size = $row['size'];
							$imgpath = $row['img'];
							$subtotal = $subtotal + $item_price * $item_qty;
							print"<tr id='$item_code'>
							<td><img src='/store/images/products/$imgpath'></td>
							<td>$item_code</td>
							<td>$item_name</td>
							<td>$$item_price</td>
							<td>$item_qty</td>
							<td>$item_size</td>
							</tr>";
						}
       				}
					?>
						
					</table>
					</div>
					<!-- end the cart preview -->

					<br/>
					<h6>- Your Shipping Info:</h6>
					<br/>
					<br/>
					<div class="billing_form_vali_super_wrapper">
						<table border="1">
							<tr>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Shipping Address</th>
								<th>Shipping Address 2</th>
								<th>City</th>
								<th>State</th>
								<th>Zip Code</th>
								<th>Phone</th>
								<th>E-mail</th>
							</tr>
							<?php
					  print "<tr>
					  			<td>$first_name</td>
					  			<td>$last_name</td>
					  			<td>$shipping_address_1</td>
					  			<td>$shipping_address_2</td>
					  			<td>$city</td>
					  			<td>$state</td>
					  			<td>$zipcode</td>
					  			<td>$phone</td>
					  			<td>$email</td>
							</tr>";
							?>
						</table>

						<br/>
						<br/>

						<table border="1">

							<h6>- Total Cost</h6>
							<br/>
						<br/>
							<tr>
								<th>Subtotal +</th>
								<th>Tax +</th>
								<th>Shipping Cost +</th>
								<th> = Total</th>
							</tr>
						<tr>
						<?php
							$sql = "SELECT cart.product_id, cart.qty, products.product_code, products.price FROM cart, products WHERE cart.product_id = products.product_code AND session_id = '$session'";
							$query = $db->query($sql);

							if ($query->num_rows > 0) {
								$subtotal = 0;
								while ($row = $query->fetch_assoc()) {
									$qty = $row['qty'];
									$price = $row['price'];

									$subtotal = $subtotal + $price * $qty;
								}
								print "<td>";
								print '$'.$subtotal;
							}
						?>
						</td>
						<td>
							<?php $tax = 2; print '$'.$tax; ?>		
						</td>
						<td>
						<?php
							$shippingcost = 10; print '$'.$shippingcost;
						?>
						</td>
							<td><?php $total = $subtotal + $tax + $shippingcost;
								print '$'.$total?></td>
						</tr>
						</table>

					</div>

				</div>

				<div class="hidden_form">
					<form method="post"action="/store/checkout/3/">					<input type="hidden" name="first_name" maxlength="40" size="40" value="<?php print $first_name?>">
					<input type="hidden" name="last_name" maxlength="40"  size="40" value="<?php print $last_name?>">
					<input type="hidden" name="shipping_address"  size="80" placeholder='Shipping Address 1' value="<?php print $shipping_address_1?>"><br/>
					<input type="hidden" name="shipping_address2" size="80" placeholder='Shipping Address 2' value="<?php print $shipping_address_2?>"> 
					<input type="hidden" name="city" size="20" value="<?php print $city?>">
					<input type="hidden" name="state" size="20" value="<?php print $state?>">
					<input type="hidden" name="zip_code" size="20" value="<?php print $zipcode?>">
					<input type="hidden" name="phone" size="20" value="<?php print $phone?>">
					<input type="hidden" name="email" size="40" value="<?php print $email?>">
					<br/>
					<input type="submit" value="Submit">
				</form>

				</div>
				<br/>
				<br/>
				<br/>
									<div class="proceed-checkbox">
						<h6>Note : </h6>
						<p>This is the final stage. After that you won't be able to modify your items. Check your items carefully. Change them, delete them, Take your time :)</p>
						<br/>
<br/>
					</div>
				<div class="nav-links">
				<b> &#x2190; Go Back and edit if you want to right now</b>
				</div>

			</div>
		</div>
	</div>
</section>
</body>
</html>