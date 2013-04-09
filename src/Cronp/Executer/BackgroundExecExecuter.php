<?php
namespace Cronp\Executer;

use Cronp\Schedule\Schedule;

/**
 * Class BackgroundExecExecuter
 * @package Cronp\Executer
 * @author Renato Neto
 */
class BackgroundExecExecuter implements Executer
{

    /**
     * @param Schedule $schedule
     */
    public function execute(Schedule $schedule)
    {
        exec(
            $schedule->getCommand() . ' & > /dev/null',
            $output,
            $returnCode
        );
    }

}