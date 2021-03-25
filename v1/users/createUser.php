<?php
include("../../config/db.php");
include("../../objects/Users.php");

$user = new User($pdo);

$user->CreateUser("Malin", "mallans@mail.com", "hejsan879");


?>