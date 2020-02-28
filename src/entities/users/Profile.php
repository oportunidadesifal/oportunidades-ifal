<?php

namespace Oportunista\entities\users;


class Profile implements \JsonSerializable
{
    protected $user_id;
    protected $username;
    protected $name;
    protected $surname;
    protected $gender;
    protected $enrollment;
    protected $birthday;

    public function getGender()
    {
        return $this->gender;
    }

    public function getEnrollment()
    {
        return $this->enrollment;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}