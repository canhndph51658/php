<?php 
include 'config.php';

if (empty($_SESSION['cart'])) {
    echo '<div class="alert alert-warning text-center mt-5">Giỏ hàng trống.</div>';
    exit;
}

$cart = $_SESSION['cart'];
$total_amount = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
$email = $_COOKIE['customer_email'] ?? 'Không có';
$phone = filter_var($_SESSION['phone'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$address = filter_var($_SESSION['address'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$created_at = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🧾 Thông tin đơn hàng</h4>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>SĐT:</strong> <?= htmlspecialchars($phone) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($address) ?></p>
            <p><strong>Thời gian đặt:</strong> <?= $created_at ?></p>

            <h5 class="mt-4">📚 Chi tiết giỏ hàng</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tên sách</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['title']) ?></td>
                            <td class="text-center"><?= $item['quantity'] ?></td>
                            <td class="text-end"><?= number_format($item['price']) ?>₫</td>
                            <td class="text-end"><?= number_format($item['price'] * $item['quantity']) ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p class="text-end fs-5"><strong>Tổng thanh toán: <?= number_format($total_amount) ?>₫</strong></p>
        </div>
        <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
</div>


</body>
</html>

<?php
// Sau khi hiển thị đơn hàng: xoá dữ liệu cũ
unset($_SESSION['cart']);
unset($_SESSION['phone']);
unset($_SESSION['address']);
?>
