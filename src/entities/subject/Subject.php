<?php

namespace Oportunista\entities\subject;


class Subject implements \JsonSerializable
{
    protected $id;
    protected $name;
    protected $code;
    protected $schedule;
    protected $days;
    protected $period;

    public function __construct($params)
    {
        $this->id = $params->id ?? null;
        $this->name = $params->name ?? null;
        $this->code = $params->code ?? null;
        $this->schedule = $params->schedule ?? null;
        $this->days = $params->days ?? null;
        $this->period = $params->period ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function getPeriod()
    {
        return $this->period;
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}