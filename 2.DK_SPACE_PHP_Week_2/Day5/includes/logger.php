<?php

function writeLog($action, $details = '') {
    $logDir = '../logs/';

    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true); 
    }

    $logFile = $logDir . 'log_' . date('Y-m-d') . '.txt';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $action: $details" . PHP_EOL;

    $file = fopen($logFile, 'a'); 
    fwrite($file, $logEntry);
    fclose($file);
}