<?php

namespace Oportunista\entities\opportunities;

use Oportunista\entities\users\TeacherDao;
use Oportunista\entities\users\UserDao;

class Internship extends Opportunity
{
    private $salary;
    private $numberVacantJob;
    private $weeklyWorkLoad;
    private $benefits;
    private $requirements;
    private $location;
    private $shift;
    private $code;
    private $companyId;


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
        $this->salary = (float) htmlspecialchars($params['salary']);
        $this->numberVacantJob = (int) htmlspecialchars($params['numberVacantJob']);
        $this->weeklyWorkLoad = (int) htmlspecialchars($params['weeklyWorkLoad']);
        $this->benefits = htmlspecialchars($params['benefits']);
        $this->requirements = htmlspecialchars($params['requirements']);
        $this->location = htmlspecialchars($params['location']);
        $this->shift = htmlspecialchars($params['shift']);
        $this->code = (int) htmlspecialchars($params['code']);
        $this->companyId = (int) htmlspecialchars($params['companyId']);
        $this->authorId = (int) $user_id;
        $this->id = (int) $opportunityId;
        $this->interest = false;

        $user = UserDao::find($params['authorId'] ?? $user_id);
        $dao = new TeacherDao();
        $this->author = $dao->find($user);
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getNumberVacantJob()
    {
        return $this->numberVacantJob;
    }

    public function getWeeklyWorkLoad()
    {
        return $this->weeklyWorkLoad;
    }

    public function getBenefits()
    {
        return $this->benefits;
    }

    public function getRequirements()
    {
        return $this->requirements;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getShift()
    {
        return $this->shift;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function jsonSerialize() {
        $vars = array_merge(get_object_vars($this),parent::jsonSerialize());
        return $vars;
    }
}
