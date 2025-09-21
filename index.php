<?php

require_once __DIR__ . '/src/MyProfiler/Profiler.php';

$profiler = new Profiler();
$profiler->profile(function() {
    someFunction();
    anotherFunction();

}, 'main');

function someFunction() {
    global $profiler;
    $profiler->profile(function() {
        $arr = [];
        for ($i = 0; $i < 1000; $i++) {
            $arr[] = md5($i);
        }
        anotherFunction();
        return array_sum(array_map('crc32', $arr));
    }, 'someFunction');
}

function anotherFunction() {
    global $profiler;
    $profiler->profile(function() {
        $str = '';
        for ($i = 0; $i < 10000; $i++) {
            $str .= chr(($i % 26) + 65);
        }
        return strrev($str);
    }, 'anotherFunction');
}

// Получаем данные профилирования
$reportData = $profiler->getReport();

// Подключаем шаблон отчета
include __DIR__ . '/src/View/report.php';