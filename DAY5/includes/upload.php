<?php
// upload.php

function uploadFile($file) {
    $max_size = 2 * 1024 * 1024; // 2MB
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

    // Kiểm tra kích thước và loại file
    if ($file['size'] > $max_size) {
        return "File quá lớn!";
    }

    if (!in_array($file['type'], $allowed_types)) {
        return "Định dạng file không hợp lệ!";
    }

    // Đổi tên file để tránh trùng
    $new_name = 'upload_' . time() . '_' . basename($file['name']);
    $target_path = 'uploads/' . $new_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $new_name;
    } else {
        return "Lỗi khi tải file!";
    }
}
?>
