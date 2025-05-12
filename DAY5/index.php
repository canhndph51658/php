<?php
include 'includes/header.php';
include 'includes/logger.php';
include 'includes/upload.php';
?>

<!-- Form để ghi log và tải file -->
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">
            <h4 class="text-center">Ghi Nhật Ký Hoạt Động</h4>
            <div class="mb-3">
                <label for="action" class="form-label">Hành động:</label>
                <input type="text" name="action" class="form-control" placeholder="Nhập hành động" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Chọn file minh chứng (PDF, JPG, PNG):</label>
                <input type="file" name="file" class="form-control" accept=".jpg,.png,.pdf">
            </div>
            <button type="submit" class="btn btn-primary w-100">Gửi</button>
        </form>
    </div>
</div>

<!-- Hiển thị kết quả sau khi gửi form -->
<div class="mt-4">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $user_ip = $_SERVER['REMOTE_ADDR'];

        // Ghi log hoạt động
        logActivity($action, $user_ip);

        // Xử lý upload file nếu có
        if (isset($_FILES['file'])) {
            $upload_result = uploadFile($_FILES['file']);
            echo '<div class="alert alert-info mt-3">' . $upload_result . '</div>';
        } else {
            echo '<div class="alert alert-success mt-3">Hoạt động của bạn đã được ghi lại!</div>';
        }
    }
    ?>
</div>

<!-- Form để xem nhật ký -->
<h2 class="mt-5 text-center">Xem Nhật Ký</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="view_log.php" class="card p-4 shadow">
            <div class="mb-3">
                <label for="log_date" class="form-label">Chọn ngày:</label>
                <input type="date" name="log_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Xem Log</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
