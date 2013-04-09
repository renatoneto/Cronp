<?php
namespace Tests\Cronp\Schedule;

use Cronp\Schedule\Schedule;

function time()
{
    return 1365428102;
}

class ScheduleTest extends \PHPUnit_Framework_TestCase
{

    private $schedule;
    private $path     = '/path/to/script.php';
    private $args     = ['test'];
    private $interval = 120;

    public function setUp()
    {
        $this->schedule = new Schedule($this->path, $this->interval, $this->args);
    }

    public function testAttrsOnCreateInstance()
    {
        $this->assertEquals($this->path, $this->schedule->getPathname());
        $this->assertEquals($this->interval, $this->schedule->getInterval());
        $this->assertEquals($this->args, $this->schedule->getArgs());
        $this->assertEquals($this->path . ' ' . implode(' ', $this->args), $this->schedule->getCommand());
    }

    public function testExecuteOn()
    {
        $this->schedule->setExecuteOn(time() - ($this->interval * 2));
        $this->assertEquals(time() - ($this->interval * 2), $this->schedule->getExecuteOn());

        $this->schedule->setExecuteOn(time() + ($this->interval * 2));
        $this->assertEquals(time() + ($this->interval * 2), $this->schedule->getExecuteOn());
    }

    public function testCanExecuteWithPassedTimeAndActualTime()
    {
        $this->schedule->setExecuteOn(time() - ($this->interval * 2));
        $this->assertTrue($this->schedule->canExecute());

        $this->schedule->setExecuteOn(time() - $this->interval);
        $this->assertTrue($this->schedule->canExecute());
    }

    public function testCanExecuteWithFutureTime()
    {
        $this->assertFalse($this->schedule->canExecute());
    }

}
