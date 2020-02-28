<?php

namespace Oportunista\entities\opportunities;

use Oportunista\entities\users\TeacherDao;
use Oportunista\entities\users\UserDao;

class Event extends Opportunity
{
    private $location;
    private $eventSchedule;
    private $eventDate;
    private $site;
    private $price;

    public function __construct($params, $type, $user_id, $opportunityId = null)
    {
        $this->title = htmlspecialchars($params['title']);
        $this->description = htmlspecialchars($params['description']);
        $this->type = $type;
        $this->posterBackgroundId = (int) htmlspecialchars($params['posterBackgroundId']);
        $this->posterIconId = (int) htmlspecialchars($params['posterIconId']);
        $this->closed = (bool) htmlspecialchars($params['closed']  ?? null);
        $this->version = (int) htmlspecialchars($params['version'] ?? null);
        $this->created = htmlspecialchars($params['created'] ?? null);
        $this->lastUpdate = htmlspecialchars($params['lastUpdate'] ?? null);
        $this->deleted = (bool) htmlspecialchars($params['deleted'] ?? null);
        $this->location = htmlspecialchars($params['location']);
        $this->eventSchedule = htmlspecialchars($params['eventSchedule']);
        $this->eventDate = htmlspecialchars($params['eventDate']);
        $this->site = htmlspecialchars($params['site']);
        $this->price = (float) htmlspecialchars($params['price']);
        $this->authorId = (int) $user_id;
        $this->id = (int) $opportunityId;
        $this->interest = false;

        $user = UserDao::find($params['authorId'] ?? $user_id);
        $dao = new TeacherDao();
        $this->author = $dao->find($user);
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getEventSchedule()
    {
        return $this->eventSchedule;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function jsonSerialize() {
        $vars = array_merge(get_object_vars($this),parent::jsonSerialize());
        return $vars;
    }
}
