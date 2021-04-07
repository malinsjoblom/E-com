<?php 
include("../../config/db.php");
include("../../objects/Products.php");

/*$product_id = "";
$product = "";
$description = "";
$price = ""; */

if(empty($_GET['product_id'])) {
    $error = new stdClass();
    $error->message = "No id specified!";
    $error->code = "0004";
    print_r(json_encode($error));
    die();
}

if (empty($_GET['product'])) {
    $error = new stdClass();
    $error->message = "No product specified!";
    $error->code = "0008";
    print_r(json_encode($error));
    die();
}

if (empty($_GET['description'])) {
    $error = new stdClass();
    $error->message = "No description specified!";
    $error->code = "0009";
    print_r(json_encode($error));
    die();
}

if (empty($_GET['price'])) {
    $error = new stdClass();
    $error->message = "No price specified!";
    $error->code = "0010";
    print_r(json_encode($error));
    die();
}

$product = new products($pdo);
$product->updateProducts($_GET['product_id'], $_GET['product'], $_GET['description'], $_GET['price']);




//OLD CODE
/* if(isset($_GET['product_id'])) {
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
$product->updateProducts($product_id, $product, $description, $price);
//print_r(json_encode($product->updateProducts($product_id, $product, $description, $price)));

 */
?>