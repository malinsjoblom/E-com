<?php 

include("../../config/db.php");
include("../../objects/Products.php");

//if(isset($_GET['product']) && isset($_GET['description']) && isset($_GET['price'])) {

    $product_IN = $_GET['product_IN'];
    $description_IN = $_GET['description_IN'];
    $price_IN = $_GET['price_IN'];

    $product = new products($pdo);

    $product->CreateProduct($product_IN, $description_IN, $price_IN);
    $return = $product->CreateProduct($product_IN, $description_IN, $price_IN);
    print_r(json_encode($product));
//}
