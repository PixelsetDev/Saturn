<?php

/**
 * Saturn Timings.
 *
 * Runs load time tests.
 */

namespace Saturn\TestManager;

class Timings
{
    private float $StartTime;

    public function Start()
    {
        $this->StartTime = microtime(true);
    }

    public function End(): float
    {
        return $this->StartTime - microtime(true);
    }
}