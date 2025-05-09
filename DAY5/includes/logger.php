<!-- includes/logger.php -->
<?php

function writeLog($actionDescription) {
    $date = date("Y-m-d");
    $logFile = "logs/log_{$date}.txt";

    $time = date("H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];

    $logEntry = "[{$time}] - IP: {$ip} - Action: {$actionDescription}\n";

    // Nếu file log đã tồn tại, ghi tiếp vào cuối file
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
