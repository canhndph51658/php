<?php
session_start();

// Biến toàn cục để lưu trữ tổng thu và chi trong phiên làm việc
$GLOBALS['total_income'] = 0;
$GLOBALS['total_expense'] = 0;

// Kiểm tra nếu không có giao dịch nào trong session, tạo mảng rỗng
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Hàm kiểm tra từ khóa nhạy cảm trong ghi chú
function checkSensitiveKeywords($note) {
    $keywords = ['nợ xấu', 'vay nóng'];
    foreach ($keywords as $keyword) {
        if (strpos(strtolower($note), $keyword) !== false) {
            return "⚠️ Cảnh báo: Ghi chú chứa từ khóa nhạy cảm!";
        }
    }
    return "";
}

// Xử lý khi người dùng gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_name = $_POST['transaction_name'];
    $amount = $_POST['amount'];
    $transaction_type = $_POST['transaction_type'];
    $note = $_POST['note'];
    $date = $_POST['date'];

    $errors = [];

    // Regex kiểm tra định dạng
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $transaction_name)) {
        $errors[] = "Tên giao dịch chỉ được chứa chữ và số.";
    }

    if (!is_numeric($amount) || $amount <= 0) {
        $errors[] = "Số tiền phải là một số dương.";
    }

    if (!preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $date)) {
        $errors[] = "Ngày không đúng định dạng (dd/mm/yyyy).";
    }

    $sensitive_warning = checkSensitiveKeywords($note);

    if (empty($errors)) {
        $transaction = [
            'transaction_name' => $transaction_name,
            'amount' => $amount,
            'transaction_type' => $transaction_type,
            'note' => $note,
            'date' => $date,
            'sensitive_warning' => $sensitive_warning
        ];
        $_SESSION['transactions'][] = $transaction;

        if ($transaction_type == 'thu') {
            $GLOBALS['total_income'] += $amount;
        } else {
            $GLOBALS['total_expense'] += $amount;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Giao dịch Tài chính</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="mb-4 text-center text-primary">Quản lý Giao dịch Tài chính</h1>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="transaction_name" class="form-label">Tên giao dịch</label>
                <input type="text" class="form-control" name="transaction_name" id="transaction_name" required>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Số tiền</label>
                <input type="text" class="form-control" name="amount" id="amount" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Loại giao dịch</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="transaction_type" value="thu" required>
                    <label class="form-check-label">Thu</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="transaction_type" value="chi" required>
                    <label class="form-check-label">Chi</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Ghi chú</label>
                <textarea name="note" id="note" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Ngày thực hiện</label>
                <input type="text" class="form-control" name="date" id="date" placeholder="dd/mm/yyyy" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu giao dịch</button>
        </form>

        <hr class="my-5">

        <h2 class="mb-3">Danh sách giao dịch</h2>
        <?php if (!empty($_SESSION['transactions'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>Tên giao dịch</th>
                            <th>Số tiền (VND)</th>
                            <th>Loại</th>
                            <th>Ghi chú</th>
                            <th>Ngày</th>
                            <th>Cảnh báo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['transactions'] as $transaction): ?>
                            <tr>
                                <td><?= htmlspecialchars($transaction['transaction_name']) ?></td>
                                <td><?= number_format($transaction['amount'], 0, ',', '.') ?></td>
                                <td><?= ucfirst($transaction['transaction_type']) ?></td>
                                <td><?= htmlspecialchars($transaction['note']) ?></td>
                                <td><?= htmlspecialchars($transaction['date']) ?></td>
                                <td class="text-danger"><?= $transaction['sensitive_warning'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Chưa có giao dịch nào được ghi nhận.</p>
        <?php endif; ?>

        <hr class="my-5">
        <h2>Thống kê</h2>
        <ul class="list-group w-50">
            <li class="list-group-item">Tổng thu: <strong class="text-success"><?= number_format($GLOBALS['total_income'], 0, ',', '.') ?> VND</strong></li>
            <li class="list-group-item">Tổng chi: <strong class="text-danger"><?= number_format($GLOBALS['total_expense'], 0, ',', '.') ?> VND</strong></li>
            <li class="list-group-item">Số dư: 
                <strong class="<?= ($GLOBALS['total_income'] - $GLOBALS['total_expense']) >= 0 ? 'text-success' : 'text-danger' ?>">
                    <?= number_format($GLOBALS['total_income'] - $GLOBALS['total_expense'], 0, ',', '.') ?> VND
                </strong>
            </li>
        </ul>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
