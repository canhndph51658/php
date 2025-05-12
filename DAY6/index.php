<?php
include 'config.php';

$customer_email = $_COOKIE['customer_email'] ?? '';
$cart = $_SESSION['cart'] ?? [];

// Xử lý khi POST form thêm sách vào giỏ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_REGEXP, [
        'options' => ['regexp' => '/^[0-9]{8,15}$/']
    ]);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $book_title = filter_input(INPUT_POST, 'book_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    if ($email && $phone && $address && $book_title && $quantity) {
        // Tạo sản phẩm
        $product = [
            'title' => $book_title,
            'quantity' => $quantity,
            'price' => 100000
        ];

        // Nếu sản phẩm đã có thì cộng dồn
        $found = false;
        foreach ($cart as &$item) {
            if ($item['title'] === $book_title) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $cart[] = $product;
        }

        $_SESSION['cart'] = $cart;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;
        setcookie('customer_email', $email, time() + (7 * 24 * 60 * 60), '/');

        // Ghi đơn hàng vào file JSON (nếu muốn lưu tạm)
        $orderData = [
            'customer_email' => $email,
            'products' => $cart,
            'total_amount' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            file_put_contents(CART_FILE, json_encode($orderData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        } catch (Exception $e) {
            echo '<p class="text-danger">Lỗi khi ghi file đơn hàng: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }

        // Sau khi thêm xong, load lại để tránh post lại khi refresh
        header("Location: index.php");
        exit;
    } else {
        echo '<p class="text-danger">Vui lòng nhập đầy đủ và đúng định dạng!</p>';
    }
}
?>

<!-- PHẦN HTML GIAO DIỆN: NHƯ ĐÃ BOOTSTRAP TRONG TRẢ LỜI TRƯỚC -->

<!-- Copy đoạn HTML đã đưa ở trên vào đây để có giao diện đẹp -->


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">🛒 Thêm sách vào giỏ hàng</h2>

    <form method="POST" action="index.php" class="row g-3">
        <div class="col-md-6">
            <label>Email:</label>
            <input name="email" type="email" class="form-control" required value="<?= htmlspecialchars($customer_email) ?>">
        </div>
        <div class="col-md-6">
            <label>SĐT:</label>
            <input name="phone" type="text" class="form-control" required>
        </div>
        <div class="col-12">
            <label>Địa chỉ:</label>
            <input name="address" type="text" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Tên sách:</label>
            <input name="book_title" type="text" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Số lượng:</label>
            <input name="quantity" type="number" min="1" value="1" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
        </div>
    </form>

    <hr class="my-5">

    <h3>🧾 Giỏ hàng</h3>
    <?php if (!empty($cart)): ?>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Tên sách</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price']) ?>₫</td>
                    <td><?= number_format($item['price'] * $item['quantity']) ?>₫</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <form method="POST" action="process_order.php">
            <button type="submit" class="btn btn-success mt-3">Xác nhận đặt hàng</button>
        </form>
    <?php else: ?>
        <p class="text-muted">Chưa có sách trong giỏ.</p>
    <?php endif; ?>
</div>

</body>
</html>
