<?php
namespace Tests\Cronp\Schedule;

use Cronp\Schedule\Collection;
use Cronp\Schedule\Schedule;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testRemoveUnknownSchedule()
    {
        $collection = new Collection();
        $this->assertFalse($collection->remove(new Schedule('/path/', 120)));
    }

    public function testAddSchedule()
    {
        $schedule   = new Schedule('/path/', 120);
        $collection = new Collection();
        $this->assertTrue($collection->add($schedule));
        $this->assertEquals($collection->count(), 1);
    }

    public function testRemoveSchedule()
    {
        $schedule   = new Schedule('/path/', 120);
        $collection = new Collection();
        $collection->add($schedule);

        $this->assertTrue($collection->remove($schedule));
        $this->assertEquals($collection->count(), 0);
    }

}
