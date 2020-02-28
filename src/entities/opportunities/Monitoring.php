<?php

namespace Oportunista\entities\opportunities;

use Oportunista\entities\users\TeacherDao;
use Oportunista\entities\users\UserDao;

class Monitoring extends Opportunity
{
    private $monitors;
    private $scholarship;
    private $numberOfMonitors;
    private $disciplineCode;

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
        $this->monitors = (int) htmlspecialchars($params['monitors']);
        $this->scholarship = (float) htmlspecialchars($params['scholarship']);
        $this->numberOfMonitors = (int) htmlspecialchars($params['numberOfMonitors']);
        $this->disciplineCode = htmlspecialchars($params['disciplineCode']);
        $this->authorId = (int) $user_id;
        $this->id = (int) $opportunityId;
        $this->interest = false;

        $user = UserDao::find($params['authorId'] ?? $user_id);
        $dao = new TeacherDao();
        $this->author = $dao->find($user);
    }
    public function getMonitors()
    {
        return $this->monitors;
    }

    public function getScholarship()
    {
        return $this->scholarship;
    }

    public function getNumberOfMonitors()
    {
        return $this->numberOfMonitors;
    }

    public function getDisciplineCode()
    {
        return $this->disciplineCode;
    }

    public function jsonSerialize() {
        $vars = array_merge(get_object_vars($this),parent::jsonSerialize());
        return $vars;
    }
}
