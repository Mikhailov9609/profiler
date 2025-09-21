<?php

class FunctionCallCount {
    private array $callCounts = [];

    public function increment(string $functionName): void {
        if (!isset($this->callCounts[$functionName])) {
            $this->callCounts[$functionName] = 0;
        }
        $this->callCounts[$functionName]++;
    }

    public function getCallCount(string $functionName): int {
        return $this->callCounts[$functionName] ?? 0;
    }

    public function getAllCounts(): array {
        return $this->callCounts;
    }
}