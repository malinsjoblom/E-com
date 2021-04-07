<?php 
include("../../config/db.php");
include("../../objects/Users.php");

$username = $_GET['username'];
$password = $_GET['password'];

$user = new User($pdo);
$return = new stdClass(); 
$return->token = $user->Login($username, $password);
print_r(json_encode($return));
