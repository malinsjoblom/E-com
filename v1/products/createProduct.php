<?php 

include("../../config/db.php");
include("../../objects/Products.php");

if(isset($_GET['product_name']) && isset($_GET['product_desc']) && isset($_GET['price'])) {

    $product_name = $_GET['product_name'];
    $product_desc = $_GET['product_desc'];
    $product_price = $_GET['product_price'];


    $product = new products($pdo);
    $product->CreateProduct($product_name, $product_desc, $product_price);
}


?>