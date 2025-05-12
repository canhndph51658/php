<?php
// logger.php

function logActivity($action, $user_ip) {
    $date = date('Y-m-d'); // lấy ngày hiện tại
    $log_file = "logs/log_{$date}.txt"; // xác định file log

    // Kiểm tra xem file có tồn tại không, nếu không thì tạo mới
    if (!file_exists($log_file)) {
        fopen($log_file, 'w'); // tạo file nếu chưa có
    }

    // Ghi log vào file
    $time = date('Y-m-d H:i:s'); // lấy thời gian hiện tại
    $log_message = "[{$time}] IP: {$user_ip} - Action: {$action}\n";

    file_put_contents($log_file, $log_message, FILE_APPEND); // ghi vào file log
}
?>
