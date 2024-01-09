<?php

namespace Model\User;

class UserDB
{
    protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function addUser($user)
    {
        $sql = "INSERT INTO users (username, firstname, lastname, password)(?,?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $newUser = [
            $user->getUserName(),
            $user->getUserFirstName(),
            $user->getUserLastName(),
            $user->getUserPassword()
        ];
        $stmt->execute($newUser);
    }

    public function getAllUser()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $this->createUserFromDB($results);
    }

    public function createUserFromDB($results)
    {
        $users = [];
        foreach ($results as $item) {
            $user = new User($item['username'], $item['firstname'], $item['lastname'], $item['password'], $item['id']);
            array_push($users, $user);
        }
        return $users;
    }

    public function login($username, $password)
    {
        $stmt = $this->connect->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true; // Đăng nhập thành công
        } else {
            return false; // Đăng nhập không thành công
        }
    }
}
