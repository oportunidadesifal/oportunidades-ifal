<?php

namespace Oportunista\entities\opportunities;

class ResearchesDaoTest extends \PHPUnit\Framework\TestCase
{

    private $userId = 11;
    
    public function testSaveResearchesOpportunity()
    {
        $type = 'Research';
        $researche = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'status' => 'Active',
            'modality' => 3,
            'startDate' => '12/12/40',
            'duration' => '4 months',
            'scholarship' => 455,
            'members' => 'Test Benefits'
        ];

        $researche = new Research($researche, $type, $this->userId);
        $dao = new ResearchDao();
        $result = $dao->save($researche);

        $this->assertTrue($result);
    }

    public function testGetResearchesOpportunities()
    {
        $dao = new ResearchDao();
        $result = $dao->get();

        $this->assertNotEmpty($result);
    }

    public function testUpdateMonitoringOpportunities()
    {
        $type = 'Research';
        $researche = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'status' => 'Active',
            'modality' => 3,
            'startDate' => '12/12/40',
            'duration' => '4 months',
            'scholarship' => 455,
            'members' => 'Test Benefits'
        ];

        $researche = new Research($researche, $type, $this->userId);
        $dao = new ResearchDao();
        $result = $dao->update($researche);

        $this->assertTrue($result);
    }
}
