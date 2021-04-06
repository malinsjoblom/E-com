<?php 
include("../../config/db.php");
include("../../objects/Products.php");

$product_id = "";
$product = "";
$description = "";
$price = "";

if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} else {
    $error = new stdClass();
    $error->message = "No ID specified!";
    $error->code = "0004";
    print_r(json_encode($error));
    die();
}

if(isset($_GET['product'])) {
    $product = $_GET['product'];
}

if(isset($_GET['description'])) {
    $description = $_GET['description'];
}

if(isset($_GET['price'])) {
    $price = $_GET['price'];
}

$product = new products($pdo);
$products = $product->updateProducts($product_id, $product, $description, $price);
print_r(json_encode($products));


?>