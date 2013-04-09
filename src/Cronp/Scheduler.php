<?php
namespace Cronp;

use Cronp\Schedule\Schedule;
use Cronp\Schedule\Collection;
use Cronp\Persist\SchedulePersist;
use Cronp\Executer\Executer;
use Countable;

/**
 * Class Scheduler
 * @package Cronp
 * @author Renato Neto
 */
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

    /**
     * @param SchedulePersist $persist
     * @param Executer $executer
     */
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

    /**
     * @param Schedule $schedule
     * @param null $key
     * @return bool
     */
    public function addSchedule(Schedule $schedule, $key = null)
    {
        return $this->collection->add($schedule, $key);
    }

    /**
     * @param Schedule $schedule
     * @param null $key
     * @return bool
     */
    public function removeSchedule(Schedule $schedule, $key = null)
    {
        return $this->collection->remove($schedule, $key);
    }

    /**
     * @return bool
     */
    public function clearSchedules()
    {
        $this->setCollection(new Collection());
        return true;
    }

    public function count()
    {
        return $this->collection->count();
    }

    /**
     * @param SchedulePersist $persist
     */
    public function setPersist(SchedulePersist $persist)
    {
        $this->persist = $persist;
    }

    /**
     * @param Executer $executer
     */
    public function setExecuter(Executer $executer)
    {
        $this->executer = $executer;
    }

    /**
     * @param Collection $collection
     */
    public function setCollection(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return bool
     */
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

        $this->save();
        return true;
    }

    public function save()
    {
        $this->persist->save($this->getCollection());
    }

}