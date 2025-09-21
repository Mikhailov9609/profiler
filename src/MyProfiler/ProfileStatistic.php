<?php

class ProfileStatistic {

    private array $report = [];
    private TimeMeasurement $timeMeasurement;
    private MemoryMeasurement $memoryMeasurement;
    private FunctionCallCount $functionCallCount;

    public function __construct() {
        // Removed duplicate FunctionCallCount creation
    }

    public function setTimeMeasurement(TimeMeasurement $timeMeasurement): void {
        $this->timeMeasurement = $timeMeasurement;
    }

    public function setMemoryMeasurement(MemoryMeasurement $memoryMeasurement): void {
        $this->memoryMeasurement = $memoryMeasurement;
    }

    public function setFunctionCallCount(FunctionCallCount $functionCallCount): void {
        $this->functionCallCount = $functionCallCount;
    }


    public function generateReport(string $functionName = 'anonymous'): void
    {
        $this->report[$functionName]['time'] = $this->timeMeasurement->getElapsedTimeMs();
        $this->report[$functionName]['memory'] = $this->memoryMeasurement->getMemoryUsageMB();
        $this->report[$functionName]['realMemory'] = $this->memoryMeasurement->getRealMemoryUsageMB();
        $this->report[$functionName]['peakMemory'] = $this->memoryMeasurement->getPeakMemoryUsageMB();
        $this->report[$functionName]['totalCalls'] = $this->functionCallCount->getCallCount($functionName);
    }

    public function getReport(): array {
        return $this->report;
    }

    public function getFormattedReport(): string {
        $output = "=== ПРОФИЛИРОВАНИЕ ПРОИЗВОДИТЕЛЬНОСТИ ===\n\n";
        
        if (empty($this->report)) {
            return $output . "Нет данных для отображения.\n";
        }
        
        foreach ($this->report as $funcName => $metrics) {
            $output .= "📊 Функция: {$funcName}\n";
            $output .= "   ⏱️  Время: {$metrics['time']} мс\n";
            $output .= "   💾 Память: {$metrics['memory']} KB\n";
            $output .= "   🔄 Реальная память: {$metrics['realMemory']} KB\n";
            $output .= "   📈 Пиковая память: {$metrics['peakMemory']} KB\n";
            $output .= "   📞 Вызовов: {$metrics['totalCalls']}\n";
            $output .= "   " . str_repeat("─", 35) . "\n\n";
        }
        
        return $output;
    }

    public function getTotalExecutionTime(): float {
        $total = 0;
        foreach ($this->report as $metrics) {
            $total += $metrics['time'];
        }
        return round($total, 2);
    }

    public function getTotalMemoryUsage(): float {
        $total = 0;
        foreach ($this->report as $metrics) {
            $total += $metrics['memory'];
        }
        return round($total, 3);
    }
}