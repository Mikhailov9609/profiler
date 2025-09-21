<?php

class MemoryMeasurement
{
    private int $startMemory;
    private int $endMemory;
    private int $startRealMemory;
    private int $endRealMemory;
    private int $startPeakMemory;
    private int $endPeakMemory;

    public function start(): void
    {
        $this->startMemory = memory_get_usage();
        $this->startRealMemory = memory_get_usage(true);
        $this->startPeakMemory = memory_get_peak_usage();
    }

    public function stop(): void
    {
        $this->endMemory = memory_get_usage();
        $this->endRealMemory = memory_get_usage(true);
        $this->endPeakMemory = memory_get_peak_usage();
    }

    public function getMemoryUsage(): int
    {
        return $this->endMemory - $this->startMemory;
    }

    public function getMemoryUsageKB(): int
    {
        return (int)round($this->getMemoryUsage() / 1024);
    }

    public function getMemoryUsageMB(): float
    {
        return round($this->getMemoryUsage() / 1024 / 1024, 3);
    }

    public function getRealMemoryUsage(): int
    {
        return $this->endRealMemory - $this->startRealMemory;
    }

    public function getRealMemoryUsageKB(): int
    {
        return (int)round($this->getRealMemoryUsage() / 1024);
    }

    public function getRealMemoryUsageMB(): float
    {
        return round($this->getRealMemoryUsage() / 1024 / 1024, 3);
    }

    public function getPeakMemoryUsage(): int
    {
        return $this->endPeakMemory - $this->startPeakMemory;
    }

    public function getPeakMemoryUsageKB(): int
    {
        return (int)round($this->getPeakMemoryUsage() / 1024);
    }

    public function getPeakMemoryUsageMB(): float
    {
        return round($this->getPeakMemoryUsage() / 1024 / 1024, 3);
    }
}
