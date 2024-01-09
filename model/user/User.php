<?php

namespace Model\User;

class User
{
    protected $id;
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $password;

    public function __construct($username, $firstname, $lastname, $password, $id = null)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->id = $id;
    }

    public function getUserName()
    {
        return $this->username;
    }

    public function getUserId()
    {
        return $this->id;
    }

    public function getUserFirstName()
    {
        return $this->firstname;
    }

    public function getUserLastName()
    {
        return $this->lastname;
    }

    public function getUserPassword()
    {
        return $this->password;
    }

    public function setUserName($username)
    {
        $this->username = $username;
    }

    public function setUserId($id)
    {
        $this->id = $id;
    }

    public function setUserFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setUserLastName($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setUserPassword($password)
    {
        $this->password = $password;
    }
}
