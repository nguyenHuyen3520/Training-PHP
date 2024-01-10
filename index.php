<?php

use Controller\UserController;

include './model/database/DBConnect.php';
include './model/user/UserDB.php';
include './model/user/User.php';
include './Controller/UserController.php';

$userController = new UserController();

$results = $userController->getAllUser();
var_dump($results);
foreach ($results as $user) {
    echo $user->getUserName();
    echo "</br>";
}
