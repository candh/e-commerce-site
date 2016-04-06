<?php
	include 'db.php';
	include 'cssandjs.html';
	include 'functions.php';
	session_start();
	if (isset($_SESSION['session_id'])) {
		$session = $_SESSION['session_id'];

		$sql = "SELECT * FROM cart WHERE session_id = '$session'";
		$query = $db->query($sql);

		if ($query->num_rows == 0) {
		print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! There are no items in your cart to view this page.</h5>
				<p>You must go back and shop!</p><br/>
				<p class='back'><a href='/'>Go back</a></p>
				</div>
			  </div>";
		exit;
		}
	}
	else {
		print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! There's an error</h5>
				<p>You must go back</p><br/>
				<p class='back'><a href='/'>Go back</a></p>
				</div>
			  </div>";
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Checkout</title>
</head>
<body>
	<?php include '/elements/nav.php';?>
	<div id="warning" class="warning"></div>
	<section id="view_items_cart_wrapper">
		<div class="row">
			<div class="eight candh push-by-two">
				<div id="cart_items_wrapper">
					<div id='heading-cta'>
					<h5 class='light'>
						You are now viewing :
					</h5>
					<p class='identifier'>
						<b>All items in your cart</b>
					</p>
					</div>
					<div id="cart_items_table_wrapper">
					<table border="1">
						<tr>
							<th>Item</th>
							<th>Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Size</th>
							<th>Remove ?</th>
						</tr>
					<?php
					include "db.php";

					$sql = "SELECT products.product_code, products.stock, products.name, products.price, products.img, cart.product_id, cart.qty, cart.size FROM cart, products WHERE products.product_code = cart.product_id AND session_id = '$session'";
					$query = $db->query($sql);

					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$item_code = $row['product_id'];
							$item_name = $row['name'];
							$item_price = $row['price'];
							$item_qty = $row['qty'];
							$imgpath = $row['img'];
							$item_size_cur = $row['size'];
							$current_stock = $row['stock'];

							print "<tr id='$item_code'>
							<td><img src='/images/products/$imgpath'></td>
							<td>$item_name</td>
							<td>$item_price</td>
							<td>
								<form method='post' action='/processing/view_cart.php' class='update_qty_ajax' id='form_id_$item_code'>
									<select name='qty' id='qty'>
										<option value='$item_qty'>$item_qty</option>
										";
										for ($i=1; $i < $current_stock ; $i++) { 
											print "<option value='$i'>$i</option>";
										}
								print "
									</select>
									<input type='hidden' name='product_id' value='$item_code'>
								</form>
							</td>

							<td>
								<form method='post' action='/processing/view_cart.php' class='update_size_ajax' id='form_size_id_$item_code'>
									<select name='size' id='size'>
										<option value='$item_size_cur'>$item_size_cur</option>
										";
											$sqltemp = "SELECT size FROM product_details WHERE product_code = '$item_code'";
											$querytemp = $db->query($sqltemp);
											if ($querytemp->num_rows>0) {
												while ($row = $querytemp->fetch_assoc()) {
													$item_size_av = $row['size'];
													print "<option value='$item_size_av'>$item_size_av</option>";
												}
											}
											else {
												print "Standard";
											}
										print"
									</select>
										<input type='hidden' name='product_id' value='$item_code'>
								</form>
							</td>

							<td>
								<i class='fa fa-close fa-2x remove' data-action='$item_code'></i>
							</td>
							
							</tr>";
							
						}
					}
					?>	
					</table>
					</div>
					<div>Your total is : <b><span id='sum' class='price'></span></b></div>
					<br/>
					<div class="row">
						<div class="eight candh">
					<div class="proceed-checkbox">
						<br/>
						<a href="/checkout/1/">
							<button id="checkout">Proceed To Checkout</button>
						</a>
					</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>