<?php 

include("../../config/db.php");
include("../../objects/Products.php");

//if(isset($_GET['product_name']) && isset($_GET['product_desc']) && isset($_GET['price'])) {

    $product_name_IN = $_GET['product_name_IN'];
    $product_desc_IN = $_GET['product_desc_IN'];
    $product_price_IN = $_GET['product_price_IN'];

    $product = new products($pdo);

    $product->CreateProduct($product_name_IN, $product_desc_IN, $product_price_IN);
    $return = $product->CreateProduct($product_name_IN, $product_desc_IN, $product_price_IN);
    print_r(json_encode($product));
//}
