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
    <?php 
         include 'cssandjs.html';
         include 'functions.php';
    ?>
    <title>Product</title>
</head>

<body>
<?php
$error = "<div class='globalerror'><div class='globalerror-content'><h5>Uh-oh! There's something wrong</h5>
         <p>The page you requested isn't working. Sorry!</div></p></div>";
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['title'])) {
    $productId = "";$title="";
   print $error;
   exit();
}
else {
    $productId = $_GET['id'];
}
    include 'elements/nav.php';
    include 'db.php';

    $sql = "SELECT * FROM cart WHERE product_id='$productId' AND session_id = '$session'";
    $query = $db->query($sql);

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $qty = $row['qty'];
        }
    }
    else {
        $qty = 0;
        print "Something went wrong";
    }


    $sql = "SELECT * FROM products WHERE product_code = $productId";
    $query = $db->query($sql);
    if ($query->num_rows > 0) {
    $row = $query->fetch_assoc();
            $productId = $row['product_code'];
            $productName = $row['name'];
            $productDesc = $row['description'];
            $productPrice = $row['price'];
            $imgpath = $row['img'];
            $current_stock = $row['stock'];
            $productNameUrl = formatUrl($productName);
        print "<section id='productView-super-wrapper'>
            <div class='row'>
                <div class='eight candh push-by-two'>
                    <div class='productView-wrapper'>
                        <div class='productView-content-wrapper'>
                            <div class='four candh haider'>
                                <div class='productView-left big_img_wrap '>
                                    <div class='focusWindow'>

                                          <img class='imgFocus' src='/store/images/products/$imgpath'> 

                                    </div>

                                    <div id='mini_img_gallery_wrapper'>
                                        <p style='font-size:13px;'>More images for this product :</p>
                                        <br/>
                                         <img class='activeImg' src='/store/images/products/$imgpath'> 
                                    ";


                                    $sql = "SELECT * FROM imgs_ref WHERE product_code = '$productId'";

                                    $query = $db->query($sql);

                                    if ($query) {
                                        while ($row = $query->fetch_assoc()) {
                                            $img_path = $row['img_path'];

                                            print "<img src='/store/images/uploads/product_imgs/$img_path'>";

                                        }
                                    }

                                    print
                                    "
                                    </div>
                                    ";

                        

                            print "
                                </div>
                            </div>
                            <div class='six candh push-by-one'>
                                <div class='productView-right'>
                                    <h5 class='productView-title'>$productName</h5>
                                    <p class='productView-price'>$$productPrice</p>
                                    <br/>
                                    <br/>
                                    <p class='prodcutView-description'>
                                        $productDesc
                                    </p>
                                    <hr/><br/>";
                                if ($qty == 0) {
                                        if ($current_stock > 1) {                                    
                                        print "
                                       <div id='qtySelect'>
                                       <form method='post' action='/store/processing/cart_submit.php' class='cartsubmitAjax'>
                                         Quantity: <br/>";
                                            print "<select name='qty' id='qty'>";
                                            for ($i=1; $i < $current_stock ; $i++) { 
                                                print "<option value='$i'>$i</option>";
                                            }
                                            print "</select> </div>";

                                        // sizes 

                                        $sql = "SELECT * FROM product_details WHERE product_code = '$productId'";
                                        $query = $db->query($sql);
                                        if ($query->num_rows > 0) {
                                              print "
                                             
                                              Available Sizes : <br/>
                                              <select name='size' id='size'>";
                                            while ($row = $query->fetch_assoc()) {
                                                $size = $row['size'];
                                                      print " <option value='$size'>$size</option>";                                                       
                                            }
                                            print "</select>";
                                        }



                                        print "
                                        <input type='hidden' value='$productId' name='product_id' id='product_id'>
                                        <br/>
                                        <br/>
                                        <input type='submit' name='submit' value='Add to Cart' id='submit' class='addSubmit'>
                                        </form>
                                        ";

                                    }
                                        else {
                                            print "<div style='color:#E73131'>Sorry, this product is out of stock</div>";
                                        }
                                }
                                else {
                                    print "
                                    <div id='qtySelect'>
                                       <form method='post' action='/store/processing/cart_submit.php' class='cartsubmitAjax'>
                                       Quantity:<br/>";
                                           print "<select name='qty' id='qty'>";
                                            for ($i=0; $i < $current_stock ; $i++) { 
                                                print "<option value='$i'>$i</option>";
                                            }
                                            print "</select>
                                    </div>";

                                        $sql = "SELECT * FROM product_details WHERE product_code = '$productId'";
                                        $query = $db->query($sql);
                                        if ($query->num_rows > 0) {
                                              print "
                                             
                                              Available Sizes : <br/>
                                              <select name='size' id='size'>";
                                            while ($row = $query->fetch_assoc()) {
                                                $size = $row['size'];
                                                      print " <option value='$size'>$size</option>";                                                       
                                            }
                                            print "</select>";
                                        }

                                        print "
                                        <input type='hidden' value='$productId' name='product_id' id='product_id'>
                                        <br/>
                                        <br/>
                                        <input type='submit' name='submit' value='Update Cart' id='submit' class='updateSubmit'>
                                        </form>";
                                }

                               print "</div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </section>
        <div id='nav-links'><a href='/store'>Store</a> <i class='fa fa-angle-right'></i> <a href='/store/products/all/box'>Products</a> <i class='fa fa-angle-right'></i> <a href='/store/product/$productId/$productNameUrl'>$productName</a></div>

        ";
    }
    else {
        print "<div class='noProduct'>
            <div class='row'>
                <div class='six candh push-by-three'>
                    <div class='nopr-content' style='margin-top:120px;'>
                    <h4>Sorry, This product couldn't be found</h4>
                    <hr/>
                    <a href='/store'><p>You can go back and browse more...</p></a>
                    </div>
                </div>
            </div>
        </div>";
        exit;
    }
?>   
    <div class='warning' id='warning'></div>
    <!-- displaying the product -->

    <!-- footer -->
    <?php include 'elements/footer.html';?>
            <!-- end footer-->
</body>

</html>