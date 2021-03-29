<?php
include("../../config/db.php");
include("../../objects/Users.php");

$username_IN = $_GET['username_IN'];
$user_email_IN = $_GET['user_email_IN'];
$password_IN = $_GET['password_IN'];

$user = new User($pdo);

$user->CreateUser("MALIN", "mallan@mail.com", "hejsan879");
$return = $user->CreateUser($username_IN, $user_email_IN, $password_IN);
print_r(json_encode($user));

?>