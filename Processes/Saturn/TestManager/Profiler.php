<?php

/**
 * Saturn Profiler.
 *
 * Runs resource usage tests.
 */

namespace Saturn\TestManager;

class Profiler
{
    public function ResourceUsage(): array
    {
        return ['memory' => ['current' => memory_get_usage(), 'peak' => memory_get_peak_usage()], 'cpu' => getrusage()];
    }
}
