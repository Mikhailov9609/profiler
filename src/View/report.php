<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Profiler - Отчет производительности</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .summary {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            padding: 25px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .summary-item {
            text-align: center;
            min-width: 150px;
        }
        
        .summary-value {
            font-size: 2em;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        
        .summary-label {
            font-size: 0.9em;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .content {
            padding: 30px;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }
        
        th {
            color: white;
            padding: 20px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        tbody tr {
            transition: all 0.3s ease;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e3f2fd;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.95em;
        }
        
        .function-name {
            font-family: 'Courier New', monospace;
            background: #ecf0f1;
            padding: 8px 12px;
            border-radius: 6px;
            color: #2c3e50;
            font-weight: bold;
            display: inline-block;
        }
        
        .metric-time {
            color: #27ae60;
            font-weight: 600;
            font-size: 1.1em;
        }
        
        .metric-memory {
            color: #e74c3c;
            font-weight: 600;
        }
        
        .metric-calls {
            background: #9b59b6;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 30px;
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
        }
        
        .no-data h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        
        .footer {
            background: #34495e;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
        }
        
        .timestamp {
            opacity: 0.8;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .summary {
                flex-direction: column;
                text-align: center;
            }
            
            .content {
                padding: 20px;
            }
            
            table {
                font-size: 0.8em;
            }
            
            th, td {
                padding: 10px 8px;
            }
            
            .function-name {
                padding: 4px 8px;
                font-size: 0.9em;
            }
        }
        
        .icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Заголовок -->
        <div class="header">
            <h1><span class="icon">📊</span>PHP Profiler</h1>
            <p>Отчет производительности приложения</p>
        </div>

        <!-- Сводная статистика -->
        <?php if (!empty($reportData)): ?>
            <?php
            $totalTime = 0;
            $totalMemory = 0;
            $totalCalls = 0;
            $functionsCount = count($reportData);
            
            foreach ($reportData as $metrics) {
                $totalTime += $metrics['time'];
                $totalMemory += $metrics['memory'];
                $totalCalls += $metrics['totalCalls'];
            }
            ?>
            <div class="summary">
                <div class="summary-item">
                    <span class="summary-value"><?= number_format($totalTime, 2) ?></span>
                    <div class="summary-label">Общее время (мс)</div>
                </div>
                <div class="summary-item">
                    <span class="summary-value"><?= number_format($totalMemory, 3) ?></span>
                    <div class="summary-label">Память (MB)</div>
                </div>
                <div class="summary-item">
                    <span class="summary-value"><?= $functionsCount ?></span>
                    <div class="summary-label">Функций</div>
                </div>
                <div class="summary-item">
                    <span class="summary-value"><?= $totalCalls ?></span>
                    <div class="summary-label">Всего вызовов</div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Основной контент -->
        <div class="content">
            <?php if (!empty($reportData)): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><span class="icon">🔧</span>Функция</th>
                                <th><span class="icon">⏱️</span>Время (мс)</th>
                                <th><span class="icon">💾</span>Память (MB)</th>
                                <th><span class="icon">🔄</span>Реальная память (MB)</th>
                                <th><span class="icon">📈</span>Пиковая память (MB)</th>
                                <th><span class="icon">📞</span>Вызовы</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData as $functionName => $metrics): ?>
                                <tr>
                                    <td>
                                        <span class="function-name"><?= htmlspecialchars($functionName) ?></span>
                                    </td>
                                    <td class="metric-time">
                                        <?= number_format($metrics['time'], 2) ?>
                                    </td>
                                    <td class="metric-memory">
                                        <?= number_format($metrics['memory'], 3) ?>
                                    </td>
                                    <td class="metric-memory">
                                        <?= number_format($metrics['realMemory'], 3) ?>
                                    </td>
                                    <td class="metric-memory">
                                        <?= number_format($metrics['peakMemory'], 3) ?>
                                    </td>
                                    <td>
                                        <span class="metric-calls"><?= $metrics['totalCalls'] ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <h3><span class="icon">📭</span>Нет данных для отображения</h3>
                    <p>Запустите профилирование для получения данных о производительности</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Подвал -->
        <div class="footer">
            <div class="timestamp">
                Отчет сгенерирован: <?= date('d.m.Y H:i:s') ?>
            </div>
            <div>PHP Profiler v2.0 - Анализ производительности</div>
        </div>
    </div>
</body>
</html>