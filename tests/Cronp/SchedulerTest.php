<?php
namespace Tests\Cronp;

use Cronp\Schedule\Schedule;
use Cronp\Scheduler;
use Cronp\Executer\BackgroundExecExecuter as Executer;
use Cronp\Persist\StreamPersist;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

function time()
{
    return 1365428102;
}

function exec($command, $output = null, $returnCode = 0)
{
    echo $command;
}

class SchedulerTest extends \PHPUnit_Framework_TestCase
{

    private $scheduler;

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('path'));

        $this->scheduler = new Scheduler(
            new StreamPersist(fopen('vfs://path/schedules.cache', 'a+')),
            new Executer()
        );
    }

    public function testCountSchedules()
    {
        $this->assertEquals(0, $this->scheduler->count());
    }

    public function testAddSchedule()
    {
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script.php', 120)));
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script2.php', 120)));
        $this->assertEquals(2, $this->scheduler->count());
    }


    public function testClearSchedules()
    {
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script.php', 120)));
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script2.php', 120)));
        $this->assertEquals(2, $this->scheduler->count());

        $this->assertTrue($this->scheduler->clearSchedules());
        $this->assertEquals(0, $this->scheduler->count());
    }

    public function testRemoveSchedule()
    {
        $schedule = new Schedule('/path/to/script.php', 120);
        $this->assertTrue($this->scheduler->addSchedule($schedule));
        $this->assertTrue($this->scheduler->removeSchedule($schedule));
        $this->assertEquals(0, $this->scheduler->count());
    }

    public function testExecute()
    {
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script.php', 120)));
        $this->assertTrue($this->scheduler->addSchedule(new Schedule('/path/to/script2.php', 120)));
        $this->assertTrue($this->scheduler->execute());
    }

}