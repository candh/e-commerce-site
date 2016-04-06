<?php
    session_start();
    if (!isset($_SESSION['session_id'])){
        $session = uniqid();
        $_SESSION['session_id'] = $session;
    }
    else {
        $session = $_SESSION['session_id'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Store</title>
    <!-- the styles and scripts -->
    <?php require 'cssandjs.html';
          require 'functions.php';
    ?>
        <!-- end -->
</head>
<body>
    <?php
	// connection to the database
	require 'db.php';
	?>
    <!-- STICKY NAVIGATIONS -->
    <?php
	include '/elements/nav.php';
	?>
            <!-- END STICKY NAVIGATION -->

            <!-- /////////////////////////////
	header
	 -->
            <div id="header-super-wrapper">
                <div class="row">
                    <div class="twelve candh">
                        <div class="header-content">
                            <div class="intro text-center">
                                <h4>Looking for boxes?</h4>
                                <p>You came to the right place</p>
                            </div>

                            <div id="search_wrapper">
                                <form action="search.php" method="get" class="searchForm">
                                    <div class="search">
                                    <i class='fa fa-search'></i><input type="text" placeholder='Search...' maxlength="30" name="search_query" id="search_query">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /////////////////////////////
	end header
	 -->
     <div class="super-promo-wrapper">
                <div class="cda-top">
                    <h5 class="text-center light">Our top Selling Boxes</h5>
                    <hr>
                </div>

    <div class="promo-content-row row push-by-two">

    <?php

        include 'db.php';

        $sql = "SELECT * FROM products ORDER BY product_code DESC LIMIT 0,3";

        $query = $db->query($sql);

        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $productId = $row['product_code'];
                $productName = $row['name'];
                $productPrice = $row['price'];
                $imgpath = $row['img'];
                $urlTitle = formatUrl($productName);
                  $init_product = "";
             $init_product.="<div class='three candh'>\n";
                $init_product.="<div class='product-card-wrapper'>\n";
                    $init_product.="<div class='product-card-content'>\n";
                        $init_product.="<div class='product-img-wrapper'>\n";
                            $init_product.="<img src='/images/products/$imgpath'>\n";
                             $init_product.="</div>\n";
                               $init_product.="<div class='product-bottom-content'>\n";
                                  $init_product.="<h6 class='product_name'>$productName</h6>";
                                     $init_product.="<p class='price'><b>$$productPrice</b></p>\n";
                                      $init_product.="<a href='/product/$productId/$urlTitle'>\n";
                                      $init_product.="<button class='buynow'>BUY NOW</button>\n";
                                  $init_product.="</a>\n";
                        $init_product.="</div>\n";
                    $init_product.="</div>\n";
                $init_product.="</div>\n";
            $init_product.="</div>\n";
                print $init_product;
            }
        }
    ?>
            </div>
    </div>
            <!-- /////////////////////////////
	promos 
	 -->

            <!-- /////////////////////////////
	additional content
	 -->
            <section>
                <div class="row">
                    <div class="twelve candh">
                        <div class="more text-center">
                            <a href="products/all/box">
                                <button>
                                    <h6 class="light">See all boxes &raquo;</h6></button>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

<!-- footer -->
 <?php include 'elements/footer.html';?>
<!-- end footer-->


    <div class='warning' id='warning'></div>
    <!-- displaying the product -->
</body>
</html>