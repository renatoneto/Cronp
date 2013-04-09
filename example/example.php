<?php
require '../vendor/autoload.php';

use Cronp\Schedule\Schedule;
use Cronp\Scheduler;
use Cronp\Executer\BackgroundExecExecuter;
use Cronp\Persist\StreamPersist;

$scheduler = new Scheduler(
    new StreamPersist(fopen('schedules.cache', 'a+')),
    new BackgroundExecExecuter()
);

if (!$scheduler->count()) {

    $path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

    $scheduler->addSchedule(new Schedule('php ' . $path . 'script', 30, ['script1']));
    $scheduler->addSchedule(new Schedule('php ' . $path . 'script', 30, ['script2']));

    $schedule = new Schedule('date >> ' . $path . 'date.txt', 30);
    $schedule->immediate();
    $scheduler->addSchedule($schedule);

}

$scheduler->execute();