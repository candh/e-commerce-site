<?php
	include '../cssandjs.html';
	include '../functions.php';
	include '../db.php';
	session_start();



	if (isset($_SESSION['session_id'])) {
		$session = $_SESSION['session_id'];
		$sql = "SELECT * FROM cart WHERE session_id = '$session'";
		$query = $db->query($sql);
		if ($query->num_rows <= 0) {
			print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>There are no items in your cart to checkout</h5>
				<p>You must go back and add items in your cart.</p><br/>
				<p class='back'><a href='/store/'>Go back</a></p>
				</div>
			  </div>";
		exit;
		}
	}
	else {
		print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! There's an error.</h5>
				<p>You must go back</p><br/>
				<p class='back'><a href='/store/'>Go back</a></p>
				</div>
			  </div>";
		exit;
	}

?>


		

<!DOCTYPE html>
<html>
<head>

	<title>Checkout</title>
	<?php
		
	?>
</head>
<body>
	<?php
		include '../elements/nav.php';
	?>
	<div id="warning" class="warning"></div>
	<section id='checkout_form_super_wrapper'>
		<div class="row">
			<div class="eight candh push-by-two">
				<div class="checkout_form">
				<div>
				<div id="heading-cta">
				<h4 class="light">
					Checkout Form
				</h4>
				<p class="identifier">
					<b>step 1</b>
				</p>
				</div>

				</div>
				<div>
				<h6>Note :</h6>
				<p>Carefully fill the form below for us to process your order</p>
				</div>
				<br/>
				<form method="post"action="/store/checkout/2/" class="checkout_form_validate">
					<p>First Name :</p>
					<input type="text" name="first_name"  class="required" id="first_name" maxlength="40" size="40">

					<p>Last Name :</p>
					<input type="text" name="last_name" class="required" id="last_name" maxlength="40"  size="40">

					<p>Shipping Address :</p>
					<input type="text" name="shipping_address"  class="required" id="shipping_address_1" size="80" placeholder='Shipping Address 1'><br/>
					<input type="text" name="shipping_address2" size="80"  placeholder='Shipping Address 2'> 

					<p>City :</p>
					<input type="text" name="city" class="required" id="city" size="20">

					<p>State/Province :</p>
					<input type="text" name="state"  class="required" id="state" size="20">

					<p>Zip Code :</p>
					<input type="text" name="zip_code" size="20">

					<p>Phone Number :</p>
					<input type="text" name="phone" class="required" id="phone" size="20">

					<p>Email :</p>
					<input type="text" name="email" size="40">
					<br/>
					<br/>
					<div id="errorcontainer"></div>
					<input type="submit" id="submitbutton" value="Submit">
				</form>


			</div>
		</div>
	</section>
	<?php include '../elements/footer.html';?>
</body>
</html>