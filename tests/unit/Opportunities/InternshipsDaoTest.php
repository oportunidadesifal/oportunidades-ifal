<?php

namespace Oportunista\entities\opportunities;

class InternshipsDaoTest extends \PHPUnit\Framework\TestCase
{

    private $userId = 11;
    
    public function testSaveInternshipOpportunity()
    {
        $type = 'Internship';
        $internship = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'salary' => 4500,
            'numberVacantJob' => 3,
            'weeklyWorkLoad' => '40',
            'minPeriod' => 3,
            'maxPeriod' => 7,
            'benefits' => 'Test Benefits',
            'requirements' => 'Test requirements',
            'activities' => 'Test Activities',
            'location' => 'Test Location',
            'shift' => '',
            'code' => 23,
            'companyId' => 45
        ];
        $internship = new Internship($internship, $type, $this->userId);
        $dao = new InternshipDao();
        $result = $dao->save($internship);

        $this->assertTrue($result);
    }

    public function testGetInternshipsOpportunities()
    {
        $dao = new InternshipDao();
        $result = $dao->get();

        $this->assertNotEmpty($result);
    }

    public function testUpdateInternshipsOpportunities()
    {
        $type = 'Internship';
        $internship = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'salary' => 4500,
            'numberVacantJob' => 3,
            'weeklyWorkLoad' => '40',
            'minPeriod' => 3,
            'maxPeriod' => 7,
            'benefits' => 'Test Benefits',
            'requirements' => 'Test requirements',
            'activities' => 'Test Activities',
            'location' => 'Test Location',
            'shift' => '',
            'code' => 23,
            'companyId' => 45
        ];
        $internship = new Internship($internship, $type, $this->userId);
        $dao = new InternshipDao();
        $result = $dao->update($internship);

        $this->assertTrue($result);
    }
}
