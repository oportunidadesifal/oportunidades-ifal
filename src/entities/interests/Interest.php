<?php

namespace Oportunista\entities\interests;

class Interest
{
    private $userId;
    private $opportunityData;
    private $opportunityId;
    private $opportunityVersion;


    public function __construct($opportunity, $userId)
    {
        $encode = json_encode($opportunity);

        $this->userId = $userId;
        $this->opportunityData = $encode;
        $this->opportunityId = $opportunity->getId();
        $this->opportunityVersion = $opportunity->getVersion();
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getOpportunityData()
    {
        return $this->opportunityData;
    }

    public function getOpportunityId()
    {
        return $this->opportunityId;
    }

    public function getOpportunityVersion()
    {
        return $this->opportunityVersion;
    }
}
