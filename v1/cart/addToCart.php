<?php
include("../../config/db.php");
include("../../objects/Cart.php");
include("../../objects/Users.php");


$token = "";
if(isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $error = new stdClass();
    $error->message = "No token specified!";
    $error->code = "0002";
    print_r(json_encode($error));
    die();
}

$user = new User($pdo);
$cart = new Cart($pdo);
if($user->isTokenValid($token)) {
    if(isset($_GET['user_id']) & isset($_GET['product_id']) & isset($_GET['quantity'])){
        $product_id = $_GET['product_id'];
        $user_id = $_GET['user_id'];
        $quantity = $_GET['quantity'];
        print_r(json_encode($cart->addToCart($product_id, $user_id, $token, $quantity))); 
    } else {
        $error = new stdClass();
        $error->message = "Please, specify user id, product id and quantity";
        $error->code = "0011";
        print_r(json_encode($error));
        die();
    }
} else {
    $error = new stdClass();
    $error->message = "Unexpected error with token, Login again..";
    $error->code = "0003";
    print_r(json_encode($error));
}
