<?php
      session_start();
      
      if (isset($_SESSION['session_id'])) {
        $session = $_SESSION['session_id'];
      }
      else {
        $session = "none";
      }
$sql = "SELECT products.price, cart.qty FROM products, cart WHERE products.product_code = cart.product_id AND session_id = '$session'";
      
		include '../db.php';
       $query = $db->query($sql);
   		$respsonse = "";
       if ($query->num_rows > 0) {
       		$subtotal = 0;
       		while ($row = $query->fetch_array()) {
       		$price = $row['price'];
       		$qty = $row['qty'];

       		$subtotal = $subtotal + $price * $qty;
       		}
          $subtotal = $subtotal;
       		$respsonse .= $subtotal;
       		print $respsonse;
       }
?>