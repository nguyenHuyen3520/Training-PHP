<?php

namespace Controller;

use Model\User\User;
use Model\User\UserDB;
use Model\Database\DBConnect;

class UserController
{
    protected $userDb;
    public function __construct()
    {
        $db = new DBConnect();
        $this->userDb = new UserDB($db->connect());
    }
    public function add($username, $firstname, $lastname, $password)
    {
        $user = new User($username, $firstname, $lastname, $password, null);
        $this->userDb->addUser($user);
    }

    public function getAllUser()
    {
        return $this->userDb->getAllUser();
    }

    public function login($username, $password)
    {
        return $this->userDb->login($username, $password);
    }

    public function getUserInfoWithUsername($username)
    {
        return $this->userDb->getUserInfoWithUsername($username);
    }
}
