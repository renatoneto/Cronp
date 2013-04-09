<?php
namespace Cronp\Executer;

use Cronp\Schedule\Schedule;

interface Executer
{

    public function execute(Schedule $schedule);

}