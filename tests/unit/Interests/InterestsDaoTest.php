<?php

namespace Oportunista\entities\interests;

class InterestsDaoTest extends \PHPUnit\Framework\TestCase
{

    private $userId = 12;
    private $opportunityId = 97;

    public function testCheckInterestsFromUserWithoutInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->checkInterests($this->userId, $this->opportunityId);

        $this->assertEquals(false, $result);
    }

    public function testInsertInterests()
    {

        $stub = $this->getMockBuilder(Interest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub->method('getOpportunityData')
            ->willReturn('data');

        $stub->method('getOpportunityId')
            ->willReturn(97);

        $stub->method('getOpportunityVersion')
            ->willReturn(1);

        $stub->method('getUserId')
            ->willReturn(12);

//        $interest = [
//            "id" => 97,
//            "version" => 1,
//        ];
//        $interest = (object) $interest;
//        $interest = new Interest($interest, $this->userId);

        $interestsDao = new InterestDao();
        $result = $interestsDao->insertInterests($stub);
        $this->assertEquals(true, $result);

        $result = $interestsDao->insertInterests($stub);
        $expected = 'You have already expressed interest in this opportunity';
        $this->assertEquals($expected, $result);
    }

    public function testGetUserInterestsWithInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->getInterests($this->userId);

        $this->assertNotEmpty($result);
    }

    public function testGetUsersInterestsByOpportunityWithInterestedUsers()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->getUsersInterestsByOpportunity($this->opportunityId);
        $this->assertNotEmpty($result);
    }

    public function testHowManyInterestsByOpportunityIdWithInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->howManyInterestsByOpportunityId($this->opportunityId);
        $this->assertEquals(1, $result);
    }

    public function testDeleteInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->deleteInterests($this->opportunityId, $this->userId);
        $this->assertEquals(true, $result);

        $result = $interestsDao->deleteInterests($this->opportunityId, $this->userId);
        $expected = 'You do not have expressed interest in this opportunity';
        $this->assertEquals($expected, $result);
    }

    public function testGetUserInterestsWithoutInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->getInterests($this->userId);

        $this->assertFalse($result);
    }

    public function testGetUsersInterestsByOpportunityWithoutInterestedUsers()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->getUsersInterestsByOpportunity($this->opportunityId);
        $this->assertFalse($result);
    }

    public function testHowManyInterestsByOpportunityIdWithoutInterests()
    {
        $interestsDao = new InterestDao();
        $result = $interestsDao->howManyInterestsByOpportunityId($this->opportunityId);
        $this->assertEquals(0, $result);
    }
}
