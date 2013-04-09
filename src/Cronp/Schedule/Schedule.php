<?php
namespace Cronp\Schedule;

/**
 * Class Schedule
 * @package Cronp\Schedule
 * @author Renato Neto
 */
class Schedule
{

    /**
     * @var string
     */
    protected $pathname;

    /**
     * @var int
     */
    protected $interval;

    /**
     * @var array
     */
    protected $args;

    /**
     * @var int
     */
    protected $executeOn;

    /**
     * @param $path
     * @param $interval
     * @param array $args
     */
    public function __construct($path, $interval, array $args = [])
    {
        $this->setPathname($path);
        $this->setInterval($interval);
        $this->setArgs($args);
        $this->setExecuteOn(time() + $this->getInterval());
    }

    /**
     * @param $path
     */
    public function setPathname($path)
    {
        $this->pathname = (string)$path;
    }

    /**
     * @return string
     */
    public function getPathname()
    {
        return $this->pathname;
    }

    /**
     * @param $interval
     */
    public function setInterval($interval)
    {
        $this->interval = (int)$interval;
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param $on int
     */
    public function setExecuteOn($on)
    {
        $this->executeOn = (int)$on;
    }

    /**
     * @return int
     */
    public function getExecuteOn()
    {
        return $this->executeOn;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        $command = $this->getPathname();

        if ($this->args) {

            $args = [];

            foreach ($this->getArgs() as $arg) {
                $args[] = ($arg == '') ? '""' : $arg;
            }

            $command .= ' ' . implode(' ', $args);
        }

        return $command;
    }

    /**
     * @return bool
     */
    public function canExecute()
    {
        return $this->getExecuteOn() <= time();
    }

    public function updateExecuteOn()
    {
        $this->setExecuteOn(time() + $this->getInterval());
    }

    public function immediate()
    {
        $this->setExecuteOn(time() - 1);
    }

}