<?php

class TimeMeasurement {
    private float $startTime;
    private float $endTime;

    public function start(): void {
        $this->startTime = microtime(true);
    }

    public function stop(): void {
        $this->endTime = microtime(true);
    }

    public function getElapsedTimeMs(): float {
        return round(($this->endTime - $this->startTime) * 1000, 2);
    }

    public function getElapsedTimeSeconds(): float {
        return $this->endTime - $this->startTime;
    }
}