<?php
include 'db.php';
include 'functions.php';
include 'cssandjs.html';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
</head>
<body>
<?php
	include 'elements/nav.php';

    if (!isset($_GET['search_query']) || empty($_GET['search_query'])) {
    print "<div class='container'>";
   print "<br/>";
print "<br/>";
print "<br/>";
print "<br/>";
    print "<br/>";
print "<br/>";
print "<br/>";
    print "<br/>";
    print "<br/>";
    print "<h5>Please enter a search query</h5>";
    print "<a href='/'><h6> &larr; Go Back<h6></a>";
    print "</div>";
    exit;
}
else {
    $query = $_GET['search_query'];
}


if (strlen($query) > 50) {
    print "<div class='container'>";
    print "<br/>";
print "<br/>";
print "<br/>";
print "<br/>";
        print "<br/>";
print "<br/>";
print "<br/>";
    print "<br/>";
    print "<br/>";

    print "<h5>Search Query is too long</h5>";
        print "<a href='/'><h6> &larr; Go Back<h6></a>";

    print "</div>";
    exit;
}
?>


      <!-- END STICKY NAVIGATION -->

     <section id='heading-cta'>
         <div class="row">
             <div class="six candh push-by-two">
                 <h5 class="light">Search Results:</h5>
                 <h6 class="identifier"><?php print $query?></h6>



                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get" class="searchForm" >
                            <div class="search-again">
                            <i class='fa fa-search'></i><input type="text" placeholder='Search...' maxlength="30" name="search_query" id="search_query">
                        </div>
                </form>

             </div>
         </div>


    </section>
    <section id='super-products-wrapper'>
        <div class="products-content">

    <!-- /////////////////////////////
	DISPLAY THE PRODUCTS.PHP
	 -->

<?php


$stmt = $db->prepare("SELECT * FROM products WHERE MATCH(name) AGAINST (?)");
$stmt->bind_param('s', $query);
$stmt->execute();

$result = $stmt->get_result();
    $jj = 1;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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

                            $init_product.="<h6>$productName</h6>";
                            $init_product.="<p class='price'>Price : <b>$$productPrice</b></p>\n";
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
    }	else {
		print "<div class='row'><div class='eight candh push-by-two text-center'><h6>Uh-oh! We're sorry for that. <br/> No results found for your search query</h6><br/><br/><a href='/'><h6> &larr; Go Back<h6></a></div></div>";
	
    }

?>      
        </div>
      
    </section>
    
    <div class='warning' id='warning'></div>
    <!-- displaying the product -->
</body>
</html>