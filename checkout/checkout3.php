<?php
	session_start();

	include '../cssandjs.html';
	include '../functions.php';
	include '../db.php';

	if (isset($_SESSION['session_id'])) {
		$session = $_SESSION['session_id'];
	}
	else {
		print "<div class='globalerror'>
				<div class='globalerror-content'>
				<h5>Uh-oh! There's an error.</h5>
				<p>You must go back!</p><br/>
				<p class='back'><a href='/'>Go back</a></p>
				</div>
			  </div>";
		exit;
	}
	$response = "";

	if (!isset($_POST['first_name'],$_POST['last_name'],$_POST['shipping_address'],$_POST['city'],$_POST['phone'])) {
		$response .= "Fill out the required fields";
		print $response;
		exit;
	}
	else {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$shipping_address_1 = $_POST['shipping_address'];
		if(isset($_POST['shipping_address2'])) {
			$shipping_address_2 = $_POST['shipping_address2'];} 
			else {
				$shipping_address_2 = "";
			}
		$city = $_POST['city'];
		if(isset($_POST['state'])) {
			$state = $_POST['state'];} 
			else {
				$state = "";
			}
		if(isset($_POST['zip_code'])) 
			{$zipcode = $_POST['zip_code'];} 
		else {
				$zipcode = "";
			}
		$phone = $_POST['phone'];
		$email = $_POST['email'];
	}

	// 
	// first query will move all the data to the customers table
	// 

	// step 1 : customers_id. If it exists, we gon' pull it from the database
	//, if it don't.. well, the customers_id table auto_increments itself

	$sql = "SELECT customers.customer_id FROM customers WHERE session_id = '$session'";
	$query = $db->query($sql);

	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$customer_id = $row['customer_id'];
		}
	}
	else {
			$customer_id = "";
	}

	// step 2 : So now we either have $customer_id or not. 
	// it is present in $customer_id. Lets dump all the data to the customers table now.

	if ($customer_id == "") {

	$stmt = $db->prepare("INSERT INTO customers (session_id, first_name, last_name, address_1, address_2, city, state, zip_code, email, phone)
						  VALUES(?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssss", $session, $first_name, $last_name, $shipping_address_1, $shipping_address_2, $city, $state, $zipcode, $email, $phone);
	$stmt->execute();

	}
	else {
	$stmt = $db->prepare("UPDATE customers SET session_id = ?, first_name = ?, last_name = ?, address_1 = ?, address_2 = ?, city = ?, state = ?, zip_code = ?, email = ?, phone = ? WHERE customer_id = ?");
	$stmt->bind_param("sssssssssis", $session, $first_name, $last_name, $shipping_address_1, $shipping_address_2, $city, $state, $zipcode, $email, $phone, $customer_id);
	$stmt->execute();
	}

	// 
	// GETTING THE CUSTOMER ID
	// 

	$sql = "SELECT customers.customer_id FROM customers WHERE session_id = '$session'";
	$query = $db->query($sql);

	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$customer_id = $row['customer_id'];
		}
	}
	else {
			$customer_id = "";
	}


	// 
	// DUMPING DATA TO THE ORDERS TABLE
	// 

	// SETTING UP THE VARIABLES
	$cost_subtotal = 0;
	$shipping_subtotal = 0;
	$cost_tax = 0;
	$cost_total = 0;

	$stmt = $db->prepare("INSERT INTO orders(customer_id, order_date, cost_subtotal, shipping_subtotal, cost_tax, cost_total, shipping_first_name, shipping_last_name, shipping_address_1, shipping_address_2, shipping_city, shipping_state, shipping_zipcode, shipping_phone, shipping_email)
						VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssssssssssss", $customer_id, $current_timestamp, $cost_subtotal, $shipping_subtotal, $cost_tax, $cost_total, $first_name, $last_name, $shipping_address_1, $shipping_address_2, $city, $state, $zipcode, $phone, $email);
	$stmt->execute();	

	// 
	// MOVING THINSG FROM CART TO ORDER_DETAILS
	//

	$sql = "SELECT orders.order_id FROM orders WHERE customer_id = '$customer_id'";
	$query = $db->query($sql);
	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$order_id = $row['order_id'];
		}
	}
	else {
		$order_id = "";
	}
	$sql = "SELECT product_id, qty, size FROM cart WHERE session_id ='$session'";
	$query = $db->query($sql);
	if ($query) {
		while ($row = $query->fetch_assoc()) {
			$qty = $row['qty'];
			$size = $row['size'];
			$product_id = $row['product_id'];
				$sql = "INSERT INTO order_details(order_id, order_qty, product_id, size)
						VALUES ('$order_id','$qty','$product_id', '$size')";
				$aquery = $db->query($sql);
		}
	}
	
	// 
	// EMPTYING THE TEMPORARY CART
	// 

	$sql = "DELETE FROM cart WHERE session_id = '$session'";
	$query = $db->query($sql);	

	//
	// GETTING THE current order information
	//

	$sql = "SELECT order_details.order_qty, order_details.product_id, products.price FROM order_details JOIN products ON order_details.product_id = products.product_code 
     		WHERE order_details.order_id = '$order_id'";
    $query = $db->query($sql);
    if ($query) {
    	$subtotal = 0;
    	while ($row = $query->fetch_assoc()) {
    		$qty = $row['order_qty'];
    		$price = $row['price'];
    		$subtotal = $subtotal + $qty * $price;
    	}
    }

    // 
    // 
    // CALCULATE COSTS

	$tax = 2.00;
	$shippingcost =10.00;
	$total = $subtotal + $tax + $shippingcost;
	$sql = "UPDATE orders SET cost_subtotal = '$subtotal', shipping_subtotal = '$shippingcost', cost_tax = '$tax', cost_total = '$total' WHERE order_id = '$order_id'";
	$query = $db->query($sql);
	if ($query) {
	}
	else {
		print "$db->error";
	}


	//
	// 
	// UPDATING INVENTORY / TOTAL ITEMS SOLD......

	$sql = "SELECT product_id, order_qty FROM order_details WHERE order_id = '$order_id'";
	$query = $db->query($sql);

	if ($query->num_rows > 0) {
		while ($row = $query->fetch_assoc()) {
			$product_id_temp = $row['product_id'];
			$order_qty_temp = $row['order_qty'];
			$sqltemp = "SELECT * FROM products WHERE product_code = '$product_id_temp'";
			$querytemp_ret = $db->query($sqltemp);
			if ($querytemp_ret->num_rows > 0) {
				while ($row = $querytemp_ret->fetch_assoc()) {
					$instock_temp_cur = $row['stock'];
				}
			}
			// updating the products table with the new quantity of the stock
			$updatedstock_init = ($instock_temp_cur - $order_qty_temp);
			$sqltemp2 = "UPDATE products SET stock = '$updatedstock_init' WHERE product_code = '$product_id_temp'";
			$querytemp = $db->query($sqltemp2);
			// updating the sold items
			$sqltemp3 = "SELECT sold FROM products WHERE product_code = '$product_id_temp'";
			$querytemp_sold = $db->query($sqltemp3);

			while ($row = $querytemp_sold->fetch_assoc()) {
				$prevSold = $row['sold'];
			}
			$currentSold = $prevSold + $order_qty_temp;
			$sqltemp4 = "UPDATE products SET sold = '$currentSold' WHERE product_code = '$product_id_temp'";
			$querytemp_sold_update = $db->query($sqltemp4);
		}
	}


	
    ?>	

    <!DOCTYPE html>
    <html>

    <head>
        <title>Check Out Step 3</title>
    </head>

    <body>
        <?php
		include '../elements/nav.php';
		?>
            <section id='final_checkout_super_wrapper'>
                <div class="row">
                    <div class="eight candh push-by-two">
                        <div id="final_checkout">
                            <div>
                            	<div id="heading-cta">
                                <h4 class="light">Checkout</h4>
                                <p class="identifier"><b>Thank you</b></p>
                                </div>
                                <h5>Here's a recap of your order</h5>
                                <p>A copy of this will be sent to you via email (if provided)</p>
                                <br/>
                            </div>
                            <br/>
                            <h6>- Items ordered :</h6>
                            <br/>
                            <div class="product_recap_table_wrapper">
                                <table border="1">
                                    <tr>

                                        <th>Item Code</th>
                                        <th>Item</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Size</th>
                                    </tr>
                     <?php
					include "../db.php";
					$sql = "SELECT customers.customer_id FROM customers WHERE session_id = '$session'";
					$query = $db->query($sql);
					if ($query) {
						while ($row = $query->fetch_assoc()) {
							$customer_id_prev = $row['customer_id'];
						}
					}
					else {
						print $db->error;
					}
					$sql = "SELECT orders.order_id FROM orders WHERE customer_id = '$customer_id_prev'";
					$query = $db->query($sql);
					if ($query) {
						while ($row = $query->fetch_assoc()) {
							$order_id_prev = $row['order_id'];
						}
					}
					else {
						print $db->error;
					}
					$sql = "SELECT order_details.order_id, order_details.size, order_details.order_qty, order_details.product_id,
    						products.name, products.price, products.img
    						FROM order_details INNER JOIN products ON order_details.product_id = products.product_code
    						WHERE order_details.order_id = '$order_id_prev'";
    				$query = $db->query($sql);
					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$subtotal = 0;
							$item_code = $row['product_id'];
							$item_name = $row['name'];
							$item_price = $row['price'];
							$item_qty = $row['order_qty'];
							$item_size = $row['size'];
							$imgpath = $row['img'];
							print"<tr id='$item_code'>
							<td><img src='/images/products/$imgpath'></td>
							<td>$item_code</td>
							<td>$item_name</td>
							<td>$$item_price</td>
							<td>$item_qty</td>
							<td>$item_size</td>
							</tr>";
						}
       				}
       				else {
       					print $db->error;
       				}
					?>
                         </table>
                            </div>
                            <!-- end the cart preview -->
                            <div id="info_preview_table_preview">
                                <br/>
                                <br/>
                                <h6>- Shipping Info Provided :</h6>
                                <br/>
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
							$sql = "SELECT * FROM orders WHERE order_id = $order_id_prev";
							$query = $db->query($sql);
							if ($query) {
								while ($row = $query->fetch_assoc()) {
									$first_name = $row['shipping_first_name'];
									$last_name = $row['shipping_last_name'];
									$shipping_address_1 = $row['shipping_address_1'];
									$shipping_address_2 = $row['shipping_address_2'];
									$city = $row['shipping_city'];
									$state = $row['shipping_state'];
									$zipcode = $row['shipping_zipcode'];
									$phone = $row['shipping_phone'];
									$email = $row['shipping_email'];

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

								}
							}
							else
							{
								print $db->error;
							}
							?>
                                </table>


                                <br/>
                                <br/>

                             <h6>- Your total is:</h6>

             				<table border="1">

							
						<br/>
							<tr>
								<th>Subtotal +</th>
								<th>Tax +</th>
								<th>Shipping Cost +</th>
								<th> = Total</th>
							</tr>
							<tr>
							<?php
							$sql = "SELECT cost_subtotal, shipping_subtotal, cost_tax, cost_total FROM orders WHERE order_id = '$order_id_prev' AND customer_id = '$customer_id_prev'";
							$query = $db->query($sql);

							if ($query) {
								while ($row = $query->fetch_assoc()) {
									$subtotal = $row['cost_subtotal'];
									$shipping = $row['shipping_subtotal'];
									$tax = $row['cost_tax'];
									$total = $row['cost_total'];
								}
								print "<td>$$subtotal</td>
										<td>$$tax</td>
										<td>$$shipping</td>
										<td>$$total</td>";
							}
							?>
							</tr>
                             </table>
                            </div>

                            <br/>

                        </div>

                    </div>
                </div>
                </div>
            </section>
    </body>

    </html>

    <?php
	session_unset();
	session_destroy();
?>