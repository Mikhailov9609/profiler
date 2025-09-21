<?php

require_once __DIR__ . '/TimeMeasurement.php';
require_once __DIR__ . '/MemoryMeasurement.php';
require_once __DIR__ . '/ProfileStatistic.php';
require_once __DIR__ . '/FunctionCallCount.php';

class Profiler {
    private FunctionCallCount $functionCallCount;
    private ProfileStatistic $profileStatistic;

    public function __construct() {
        // Инициализация профайлера с заданным интервалом сэмплирования
        $this->functionCallCount = new FunctionCallCount();
        $this->profileStatistic = new ProfileStatistic();
    }

    public function profile(callable $func, string $funcName = 'anonymous'): mixed {
        $this->functionCallCount->increment($funcName);
        
        // Создаем новые объекты измерений для каждого профилирования
        $memoryMeasurement = new MemoryMeasurement();
        $timeMeasurement = new TimeMeasurement();
        
        // Профилирование переданной функции
        $memoryMeasurement->start();
        $timeMeasurement->start();

        $result = $func();

        $timeMeasurement->stop();
        $memoryMeasurement->stop();

        $this->profileStatistic->setTimeMeasurement($timeMeasurement);
        $this->profileStatistic->setMemoryMeasurement($memoryMeasurement);
        $this->profileStatistic->setFunctionCallCount($this->functionCallCount);

        $this->profileStatistic->generateReport($funcName);
        
        return $result;
    }

    public function getReport(): array {
        // Получение отчета о профилировании
        return $this->profileStatistic->getReport();
    }

    public function reset(): void {
        // Сброс всех накопленных данных
        $this->functionCallCount = new FunctionCallCount();
        $this->profileStatistic = new ProfileStatistic();
    }

    public function getTotalCalls(): array {
        // Получение общего количества вызовов функций
        return $this->functionCallCount->getAllCounts();
    }

    public function getFormattedReport(): string {
        // Получение красиво отформатированного отчета
        return $this->profileStatistic->getFormattedReport();
    }

    public function getTotalExecutionTime(): float {
        // Получение общего времени выполнения всех профилированных функций
        return $this->profileStatistic->getTotalExecutionTime();
    }

    public function getTotalMemoryUsage(): int {
        // Получение общего использования памяти всех функций
        return $this->profileStatistic->getTotalMemoryUsage();
    }

}