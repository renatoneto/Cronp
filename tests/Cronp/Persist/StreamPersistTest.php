<?php
namespace Tests\Cronp\Persist;

use Cronp\Schedule\Collection;
use Cronp\Schedule\Schedule;
use Cronp\Persist\StreamPersist;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

class StreamPersistTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('path'));
    }

    public function testInstanceWithInvalidStream()
    {
        $this->setExpectedException('InvalidArgumentException');
        new StreamPersist('path');
    }

    public function testSave()
    {
        $persist = new StreamPersist(fopen('vfs://path/schedules.cache', 'a+'));

        $collection = new Collection();
        $collection->add(new Schedule('/path/to/script.php', 120));

        $this->assertTrue($persist->save($collection));
    }

    public function testLoad()
    {
        $persist    = new StreamPersist(fopen('vfs://path/schedules.cache', 'a+'));
        $collection = new Collection();
        $collection->add(new Schedule('/path/to/script.php', 120));
        $persist->save($collection);

        $this->assertEquals($collection, $persist->load());
    }

}
