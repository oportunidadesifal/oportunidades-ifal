<?php

namespace Oportunista\entities\opportunities;

class MonitoringDaoTest extends \PHPUnit\Framework\TestCase
{

    private $userId = 11;
    
    public function testSaveMonitoringOpportunity()
    {
        $type = 'Monitoring';
        $monitoring = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'monitors' => 4,
            'scholarship' => 344,
            'numberOfMonitors' => 4,
            'disciplineCode' => 3
        ];
        $monitoring = new Monitoring($monitoring, $type, $this->userId);
        $dao = new MonitoringDao();
        $result = $dao->save($monitoring);

        $this->assertTrue($result);
    }

    public function testGetMonitoringOpportunities()
    {
        $dao = new MonitoringDao();
        $result = $dao->get();

        $this->assertNotEmpty($result);
    }

    public function testUpdateMonitoringOpportunities()
    {
        $type = 'Monitoring';
        $monitoring = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'monitors' => 4,
            'scholarship' => 344,
            'numberOfMonitors' => 4,
            'disciplineCode' => 3
        ];

        $monitoring = new Monitoring($monitoring, $type, $this->userId);
        $dao = new MonitoringDao();
        $result = $dao->update($monitoring);

        $this->assertTrue($result);
    }
}
