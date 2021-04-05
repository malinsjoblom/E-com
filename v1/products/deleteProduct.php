<?php 

include("../../config/db.php");
include("../../objects/Products.php");

$product = new products($pdo);

if(!empty($_GET['id'])) {
    echo json_encode($product->deleteProduct($_GET['id']));

} else {
    $error = new stdClass();
    $error->message = "No ID specified!";
    $error->code = "0004";
    echo json_encode($error);
    die();
}   

?>