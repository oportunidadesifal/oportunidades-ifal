<?php

namespace Oportunista\entities\opportunities;

class EventsDaoTest extends \PHPUnit\Framework\TestCase
{

    private $userId = 11;

    public function testSaveEventOpportunity()
    {
        $type = 'Event';
        $event = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'location' => 'Test Location',
            'eventSchedule' => '',
            'eventDate' => '',
            'site' => '',
            'price' => 23
        ];
        $event = new Event($event, $type, $this->userId);
        $dao = new EventDao();
        $result = $dao->save($event);
        
        $this->assertTrue($result);
    }

    public function testGetEventsOpportunities()
    {
        $dao = new EventDao();
        $result = $dao->get();

        $this->assertNotEmpty($result);
    }

    public function testUpdateEventsOpportunities()
    {
        $type = 'Event';
        $event = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'posterBackgroundId' => 0,
            'posterIconId' => 1,
            'location' => 'Test Location',
            'eventSchedule' => '',
            'eventDate' => '',
            'site' => '',
            'price' => 23
        ];
        $event = new Event($event, $type, $this->userId);
        $dao = new EventDao();
        $result = $dao->update($event);

        $this->assertTrue($result);
    }
}