<?php
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_date = $_POST['log_date'];
    $log_file = "logs/log_{$selected_date}.txt";

    echo '<div class="mt-4">';
    if (file_exists($log_file)) {
        $file_content = file_get_contents($log_file);
        echo '<div class="card p-4 shadow"><pre>' . nl2br($file_content) . '</pre></div>';
    } else {
        echo '<div class="alert alert-warning">Không có nhật ký cho ngày này.</div>';
    }
    echo '</div>';
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
