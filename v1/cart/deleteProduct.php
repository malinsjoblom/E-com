<?php
include("../../config/db.php");
include("../../objects/Cart.php");
include("../../objects/Users.php");


$token = "";
if(isset($_GET['token'])) {
    $tokoen = $_GET['token'];
} else {
    $error = new stdClass();
    $error->message = "No token specified";
    $error->code = "0002";
    print_r(json_encode($error));
    die();
}

$user = new User($pdo);
$cart = new Cart($pdo);
if($user->isTokenValid($token)) {
    if(isset($_GET['user_id']) & isset($_GET['product_id'])) {
        $user_id = $_GET['user_id'];
        $product_id = $_GET['product_id'];
        $cart = new Cart($pdo);
        print_r(json_encode($cart->deleteProduct($user_id, $product_id)));
    } else {
        $error = new stdClass();
        $error->message = "The id is not specified";
        $error->code = "0004";
        echo json_encode($error);
        die();
    }
} else {
    $error = new stdClass();
    $error->message = "Unexpected error with token, Login again..";
    $error->code = "0003";
    print_r(json_encode($error));
}
