<?php
include("../../config/db.php");
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

if($user->isTokenValid($token)) {
    $users = $user->GetAllUsers();
    print_r(json_encode($users));

} else {
    $error = new stdClass();
    $error->message = "Unexpected error, Login again..";
    $error->code = "0003";
    print_r(json_encode($error));
}



?>