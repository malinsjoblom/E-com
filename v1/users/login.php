<?php 
include("../../config/db.php");
include("../../objects/Users.php");

$username_IN = $_GET['username_IN'];
$password_IN = $_GET['password_IN'];

$user = new User($pdo);
$return = new stdClass();
$return->token = $user->Login($username_IN, $password_IN);
print_r(json_encode($return));
