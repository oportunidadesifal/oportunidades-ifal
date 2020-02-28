<?php

namespace Oportunista\entities\opportunities;

use Oportunista\entities\users\TeacherDao;
use Oportunista\entities\users\User;
use Oportunista\entities\users\UserDao;

class Opportunity implements \JsonSerializable
{
    protected $id;
    protected $title;
    protected $description;
    protected $authorId;
    protected $author;
    protected $type;
    protected $posterIconId;
    protected $posterBackgroundId;
    protected $closed;
    protected $version;
    protected $created;
    protected $lastUpdate;
    protected $deleted;
    protected $interest;

    public function __construct($params)
    {
        $this->id = $params->id;
        $this->title = $params->title;
        $this->description = $params->description;
        $this->authorId = $params->authorId;
        $this->type = $params->type;
        $this->posterIconId = $params->posterIconId;
        $this->posterBackgroundId = $params->posterBackgroundId;
        $this->closed = $params->closed;
        $this->version = $params->version;
        $this->created = $params->created;
        $this->lastUpdate = $params->lastUpdate;

        $user = UserDao::find($params->authorId);
        $dao = new TeacherDao();
        $this->author = $dao->find($user);
    }

    public function getPosterBackgroundId()
    {
        return $this->posterBackgroundId;
    }

    public function getPosterIconId()
    {
        return $this->posterIconId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClosed()
    {
        return $this->closed;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function setInterest($interest)
    {
        $this->interest = $interest;
    }

    public function getCreated()
    {
        return $this->created;
    }
}
