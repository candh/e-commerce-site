<?php
    session_start();
    if (isset($_SESSION['session_id'])) {
        $session = $_SESSION['session_id'];
    }
    else {
        $session = uniqid();
        $_SESSION['session_id'] = $session; 
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Products</title>
        <?php require 'cssandjs.html'; include 'functions.php';?>
    </head>
    <body>
    <?php
$error = "<div class='globalerror'><div class='globalerror-content'><h5>Uh-oh! There's something wrong</h5>
         <p>The page you requested isn't working. Sorry!</div></p></div>";
    $v = $_GET['v'];
    $cat = $_GET['cat'];

    if ($v != 'all' || $cat != 'box') {
       print $error;
       exit();
    }
    ?>
    <!-- STICKY NAVIGATIONS -->
    <?php
	include 'elements/nav.php';
	?>
      <!-- END STICKY NAVIGATION -->

     <section id='heading-cta'>
         <div class="row">
             <div class="six candh push-by-two">
                 <h5 class="light">You are now viewing :</h5>
                 <h6 class="identifier">All Boxes</h6>
             </div>
         </div>
    </section>


    <section id='super-products-wrapper'>
        <div class="products-content">

    <!-- /////////////////////////////
	DISPLAY THE PRODUCTS.PHP
	 -->

    <?php
    include 'db.php';
    $sql = "SELECT * FROM products ORDER BY product_code DESC";
    $query = $db->query($sql);
    $num_of_rows = ceil(($query->num_rows) / 3);
    $jj = 1;
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

            if ($jj == 1) {
            print "<div class='product-content-row row push-by-two'>\n";
            }
            if ($jj < 3) {
                $jj++;
                print $init_product;
            }
            else {
                print $init_product;
                print "</div>\n";
                $jj=1;            
            }

            // shabash my nigga. you did this. Celebrate
        }
    }
    else {
        print "<div class='noProduct'>
            <div class='row'>
                <div class='six candh push-by-three'>
                    <div class='nopr-content' style='margin-top:120px;'>
                    <h4>Sorry, This product couldn't be found</h4>
                    <hr/>
                    <a href='/'><p>You can go back and browse more...</p></a>
                    </div>
                </div>
            </div>
        </div>";
        exit;
    }
    ?>
      </div>
    </section>

     <!-- footer -->
    <?php include '/elements/footer.html';?>
    <!-- end footer-->
    </body>

    </html>