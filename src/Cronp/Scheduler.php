<?php
namespace Cronp;

use Cronp\Schedule\Schedule;
use Cronp\Schedule\Collection;
use Cronp\Persist\SchedulePersist;
use Cronp\Executer\Executer;
use Countable;

class Scheduler implements Countable
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var SchedulePersist
     */
    protected $persist;

    /**
     * @var Executer
     */
    protected $executer;

    public function __construct(SchedulePersist $persist, Executer $executer)
    {
        $this->setPersist($persist);
        $this->setExecuter($executer);
        $this->loadCollectionFromPersist();
    }

    public function loadCollectionFromPersist()
    {
        $this->collection = $this->persist->load();
    }

    public function addSchedule(Schedule $schedule, $key = null)
    {
        return $this->collection->add($schedule, $key);
    }

    public function removeSchedule(Schedule $schedule, $key = null)
    {
        return $this->collection->remove($schedule, $key);
    }

    public function clearSchedules()
    {
        $this->setCollection(new Collection());
        return true;
    }

    public function count()
    {
        return $this->collection->count();
    }

    public function setPersist(SchedulePersist $persist)
    {
        $this->persist = $persist;
    }

    public function setExecuter(Executer $executer)
    {
        $this->executer = $executer;
    }

    public function setCollection(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function execute()
    {
        /**
         * @var Schedule $schedule
         */
        foreach ($this->getCollection() as $schedule) {

            if ($schedule->canExecute()) {
                $this->executer->execute($schedule);
                $schedule->updateExecuteOn();
            }

        }

        $this->persist->save($this->getCollection());
        return true;
    }

}