<?php

namespace Oportunista\entities\users;

class Student extends Profile
{
    private $interests;
    private $university_id;

    public function __construct($params, $user)
    {
        $this->user_id = $user->getId();
        $this->username = $user->getUsername();
        $this->name = htmlspecialchars($params['name']);
        $this->surname = htmlspecialchars($params['surname']);
        $this->gender = htmlspecialchars($params['gender']);
        $this->enrollment = htmlspecialchars($params['enrollment']);
        $this->birthday = htmlspecialchars($params['birthday']);
        $this->interests = $params['interests'] ?? null;
        $this->university_id = htmlspecialchars($params['university_id']);
    }

    public function getInterests()
    {
        return $this->interests;
    }

    public function getUniversityId()
    {
        return $this->university_id;
    }

    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    public function jsonSerialize() {
        $vars = array_merge(parent::jsonSerialize(),get_object_vars($this));
        return $vars;
    }
}
