<?php 
include("../../config/db.php");
include("../../objects/Users.php");

$username_IN = $_GET['username_IN'];
$user_password_IN = $_GET['user_password_IN'];

$user = new User($pdo);
$return = new stdClass();
$return->token = $user->Login($username_IN, $user_password_IN);
print_r(json_encode($return));


?>