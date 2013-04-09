<?php
namespace Cronp\Persist;

use Cronp\Schedule\Collection;

interface SchedulePersist
{

    public function save(Collection $schedules);

    public function load();

}