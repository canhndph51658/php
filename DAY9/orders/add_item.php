<?php require '../db.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thêm sản phẩm vào đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">

    <h2>🛒 Thêm sản phẩm vào đơn hàng</h2>

    <form method="post" class="mb-3">
        <div class="mb-3">
            <label for="order_id" class="form-label">Chọn đơn hàng:</label>
            <select name="order_id" id="order_id" class="form-select" required>
                <option value="">-- Chọn đơn hàng --</option>
                <?php
                $stmt = $pdo->query("SELECT id, customer_name FROM orders ORDER BY order_date DESC");
                foreach ($stmt as $order) {
                    echo '<option value="'.htmlspecialchars($order['id']).'">'
                         .htmlspecialchars($order['id']).' - '.htmlspecialchars($order['customer_name'])
                         .'</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Chọn sản phẩm:</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">-- Chọn sản phẩm --</option>
                <?php
                $stmt = $pdo->query("SELECT id, product_name, stock_quantity FROM products ORDER BY product_name");
                foreach ($stmt as $product) {
                    echo '<option value="'.htmlspecialchars($product['id']).'">'
                         .htmlspecialchars($product['product_name'])
                         .' (Tồn: '.$product['stock_quantity'].')'
                         .'</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng:</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required />
        </div>

        <button type="submit" class="btn btn-primary">Thêm vào đơn hàng</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if (!$order_id || !$product_id || !$quantity || $quantity < 1) {
            echo '<div class="alert alert-danger">Dữ liệu không hợp lệ!</div>';
        } else {
            // Lấy tồn kho sản phẩm
            $stmt = $pdo->prepare("SELECT stock_quantity, unit_price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();

            if (!$product) {
                echo '<div class="alert alert-danger">Sản phẩm không tồn tại!</div>';
            } elseif ($product['stock_quantity'] < $quantity) {
                echo '<div class="alert alert-warning">Tồn kho không đủ. Tồn hiện tại: ' . $product['stock_quantity'] . '</div>';
            } else {
                // Thêm vào order_items
                $price_at_order_time = $product['unit_price'];
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time) VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $product_id, $quantity, $price_at_order_time]);

                // Cập nhật tồn kho sản phẩm
                $new_stock = $product['stock_quantity'] - $quantity;
                $stmt = $pdo->prepare("UPDATE products SET stock_quantity = ? WHERE id = ?");
                $stmt->execute([$new_stock, $product_id]);

                // Redirect về trang danh sách đơn hàng ngay sau khi thêm thành công
                header('Location: ../orders/index.php');
                exit;
            }
        }
    }
    ?>

</body>
</html>
