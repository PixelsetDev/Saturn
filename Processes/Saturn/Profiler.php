<?php

/**
 * Saturn Profiler.
 *
 * Runs load time and resource usage tests.
 */

namespace Saturn;

class Profiler {

    private float $StartTime;
    public float $LoadTime;

    public function Start() {
        $this->StartTime = microtime(true);
    }

    public function End() {
        $this->LoadTime = $this->StartTime -  microtime(true);
    }

    public function ResourceUsage() {
        return ['memory' => ['current' => memory_get_usage(), 'peak' => memory_get_peak_usage()], 'cpu' => getrusage()];
    }
}