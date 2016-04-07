    <?php
      session_start();
      
      if (isset($_SESSION['session_id'])) {
        $session = $_SESSION['session_id'];
      }
      else {
        $session = "none";
      }
      include '../functions.php';
       include '../db.php';
    ?>

    <div id="cart" class="text-right">
        <div class="cart-icon">
            <img src="/images/cart.svg">
        </div>
        <div class="items-qty-prev">
    <?php
    // 
    // CONNECTION TO THE DATABASE
    //
    $totalItems = 0;
   

    $sql = "SELECT COUNT(*) FROM cart WHERE session_id = '$session'";
    $query = $db->query($sql);
    if ($query->num_rows > 0) {
    		$row = $query->fetch_array();
    		$totalItems = $row[0];
    		print "<span id='item-qty' data-qty='$totalItems'>$totalItems</span>";
    }
    else {
    	 print "<span id='item-qty' data-qty='$totalItems'>$totalItems</span>";
    }
    ?>
     </div>
       
        <div id="cart-desc" class="text-left">


       <?php

       $sql = "SELECT products.product_code, products.name, products.price, cart.product_id, cart.qty, cart.size FROM products, cart WHERE products.product_Code = cart.product_id AND session_id = '$session'";
       $query = $db->query($sql);

       if ($query->num_rows > 0) {
       		$cntr = 1;
       		while ($row = $query->fetch_assoc()) {
            $product_id = $row['product_code'];
       			$productName = $row['name'];
       			$productPrice = $row['price'];
       			$productQty = $row['qty'];
            $productSize = $row['size'];

            $productNameUrl = formatUrl($productName);
       	print "<div class='/product$cntr'>
                <p><a href='/product/$product_id/$productNameUrl'><b>$productName</b> ($productQty) — ($productSize)</a></p>
                <p class='cart-price'><b>$$productPrice</b></p>
              </div>";
              $cntr++;
              $token = "Y";
       		}
       }
       else {
       	print "<b>No items here :(</b>";
        $token = "N";
       }

       if ($token != "N") {
  
       $sql = "SELECT products.price, cart.qty FROM products, cart WHERE products.product_code = cart.product_id AND session_id = '$session'";
       $query = $db->query($sql);

       if ($query->num_rows > 0) {
       		$subtotal = 0;
       		while ($row = $query->fetch_array()) {
       		$price = $row['price'];
       		$qty = $row['qty'];

       		$subtotal = $subtotal + $price * $qty;


       		}
       }
       else {
       	print "";
       }

       		print "Subtotal :
            <div id='subtotal' class='cart-price'>
                $$subtotal
            </div>

            <div id='checkout'>
                <a href='/cart'><button>Checkout</button></a>
            </div>";


       }
      ?>
        </div>
    </div>