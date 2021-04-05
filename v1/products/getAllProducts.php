<?php 

include("../../config/db.php");
include("../../objects/Products.php");

$product = new products($pdo);
$products = $product->getAllProducts();
print_r(json_encode($products));

?>