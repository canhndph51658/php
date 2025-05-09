<!-- includes/upload.php -->
<?php

function uploadFile($file) {
    // Kiểm tra định dạng và kích thước file
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowedTypes)) {
        return "File không hợp lệ.";
    }

    if ($file['size'] > $maxSize) {
        return "File quá lớn. Vui lòng chọn file nhỏ hơn 2MB.";
    }

    // Đổi tên file để tránh trùng
    $timestamp = time();
    $fileName = $timestamp . "_" . basename($file['name']);
    $targetPath = "uploads/" . $fileName;

    // Di chuyển file đến thư mục uploads
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }

    return "Có lỗi xảy ra khi tải lên file.";
}
