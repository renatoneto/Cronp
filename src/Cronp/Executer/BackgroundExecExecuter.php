<?php
namespace Cronp\Executer;

use Cronp\Schedule\Schedule;

class BackgroundExecExecuter implements Executer
{

    public function execute(Schedule $schedule)
    {
        exec(
            $schedule->getCommand() . ' & > /dev/null',
            $output,
            $returnCode
        );
    }

}