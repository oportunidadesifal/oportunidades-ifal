<?php

namespace Oportunista\entities\opportunities;

use Oportunista\entities\users\TeacherDao;
use Oportunista\entities\users\UserDao;

class Research extends Opportunity
{
    private $status;
    private $modality;
    private $startDate;
    private $duration;
    private $scholarship;
    private $members;

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
        $this->status = htmlspecialchars($params['status']);
        $this->modality = htmlspecialchars($params['modality']);
        $this->startDate = htmlspecialchars($params['startDate']);
        $this->duration = (int) htmlspecialchars($params['duration']);
        $this->scholarship = (float) htmlspecialchars($params['scholarship']);
        $this->members = (int) htmlspecialchars($params['members']);
        $this->authorId = (int) $user_id;
        $this->id = (int) $opportunityId;
        $this->interest = false;

        $user = UserDao::find($params['authorId'] ?? $user_id);
        $dao = new TeacherDao();
        $this->author = $dao->find($user);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getModality()
    {
        return $this->modality;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getScholarship()
    {
        return $this->scholarship;
    }
    
    public function getMembers()
    {
        return $this->members;
    }

    public function jsonSerialize() {
        $vars = array_merge(get_object_vars($this),parent::jsonSerialize());
        return $vars;
    }
}
