<?php
namespace Cronp\Persist;

use Cronp\Schedule\Collection;

/**
 * interface SchedulePersist
 * @package Cronp\Persist
 * @author Renato Neto
 */
interface SchedulePersist
{

    /**
     * @param Collection $schedules
     * @return mixed
     */
    public function save(Collection $schedules);

    /**
     * @return mixed
     */
    public function load();

}