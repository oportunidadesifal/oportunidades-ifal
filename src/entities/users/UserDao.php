<?php

namespace Oportunista\entities\users;

use Oportunista\Connection;
use \PDO;

class UserDao
{
    protected $connect;
    protected $user;

    public function __construct(User $user)
    {
        $this->connect = Connection::connect();
        $this->user = $user;
    }

    protected function checkUsernameExists()
    {
        $sql = "select username from users where username = :username";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':username', $this->user->getUsername());
        $stmt->execute();
        $row = $stmt->rowCount();

        if (!$row == 0) {
            return true;
        }

        return false;
    }

    public function save()
    {
        if ($this->checkUsernameExists($this->user)) {
            return "This username already exists.";
        }

        $sql = "INSERT INTO users (username, password, category) values (:username, :password, :category)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':username', $this->user->getUsername());
        $stmt->bindValue('password', $this->user->getPassword());
        $stmt->bindValue(':category', $this->user->getCategory());

        $result = $stmt->execute();

        if ($result != 1) {
            return "Could not process transaction";
        }

        return true;
    }

    public function checkUser()
    {
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':username', $this->user->getUsername());
        $stmt->bindValue(':password', $this->user->getPassword());

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return false;
        }

        $user = new User($result);
        return $user;
    }

    public static function find($id)
    {
        $connect = Connection::connect();
        $sql = "SELECT * FROM users WHERE id = :id";

        $stmt = $connect->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return false;
        }

        $user = new User($result);
        return $user;
    }
}
