<!-- index.php -->
<?php
include 'includes/header.php';
include 'includes/logger.php';
include 'includes/upload.php';

// Ghi nhật ký khi người dùng thực hiện hành động
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $actionDescription = $_POST['action_description'] ?? 'Không có mô tả hành động';
    writeLog($actionDescription);

    // Xử lý tải lên file
    if (isset($_FILES['upload_file'])) {
        $uploadResult = uploadFile($_FILES['upload_file']);
        echo "Kết quả tải lên file: " . $uploadResult;
    }

    echo "Đã ghi lại hành động: " . $actionDescription;
}
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="action_description">Mô tả hành động:</label>
    <input type="text" id="action_description" name="action_description" required><br><br>

    <label for="upload_file">Tải lên file minh chứng:</label>
    <input type="file" id="upload_file" name="upload_file"><br><br>

    <input type="submit" value="Ghi nhật ký">
</form>

<?php include 'includes/footer.php'; ?>
