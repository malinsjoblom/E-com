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
$carts = $cart->checkout($token);
print_r(json_encode($carts));
} else {
    $error = new stdClass();
    $error->message = "Unexpected error with token, Login again..";
    $error->code = "0003";
    print_r(json_encode($error));
}