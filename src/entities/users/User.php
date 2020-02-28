<?php

namespace Oportunista\entities\users;

class User
{
    protected $id;
    protected $username;
    protected $password;
    protected $category;
    
    public function __construct($params)
    {
        $this->id = $params['id'] ?? null;
        $this->username = $params['username'];
        $this->password = hash("sha256", $params['password'] ?? null);
        $this->category = ucfirst(strtolower($params['category'] ?? null));
    }

    public function getUsername()
    {
        return $this->username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getId()
    {
        return $this->id;
    }

}
