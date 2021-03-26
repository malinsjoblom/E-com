<?php
include("../../config/db.php");
include("../../objects/users.php");

$user = new User($pdo);

if( !empty($_GET['id'])) {
    $userData = $user->GetUser($_GET['id']);
    print_r(json_encode($userData));

} else {
    $error = new stdClass();
    $error->message = "No ID specified!";
    $error->code = "0004";
    print_r(json_encode($error));
    die();
}


?>