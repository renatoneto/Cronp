<?php
namespace Cronp\Executer;

use Cronp\Schedule\Schedule;

/**
 * Interface Executer
 * @package Cronp\Executer
 * @author Renato Neto
 */
interface Executer
{

    /**
     * @param Schedule $schedule
     * @return mixed
     */
    public function execute(Schedule $schedule);

}