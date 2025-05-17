<?php
require 'db.php';

$products = [
    ["Động cơ servo", 2000000, 50],
    ["Cảm biến nhiệt", 850000, 120],
    ["Bộ điều khiển PLC", 3500000, 20],
    ["Màn hình HMI", 2900000, 35],
    ["Bảng điều khiển từ xa", 1800000, 60],
];

foreach ($products as $p) {
    $stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity, created_at)
                           VALUES (?, ?, ?, NOW())");
    $stmt->execute([$p[0], $p[1], $p[2]]);
}
echo "Đã thêm 5 sản phẩm mẫu.";
$stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity, created_at)
                       VALUES (?, ?, ?, NOW())");
$stmt->execute(["Thiết bị XYZ", 1234567, 10]);

$lastId = $pdo->lastInsertId();
echo "Sản phẩm mới có ID: $lastId";

$orders = [
    ["Nguyễn Văn A", "Giao hàng nhanh", [
        ["product_id" => 1, "quantity" => 2],
        ["product_id" => 3, "quantity" => 1],
    ]],
    ["Trần Thị B", "Thanh toán khi nhận", [
        ["product_id" => 2, "quantity" => 3],
        ["product_id" => 4, "quantity" => 1],
    ]],
    ["Lê Hoàng C", "Hẹn giao sau 5 ngày", [
        ["product_id" => 5, "quantity" => 4],
        ["product_id" => 1, "quantity" => 1],
        ["product_id" => 2, "quantity" => 2],
    ]],
];

foreach ($orders as $order) {
    $pdo->beginTransaction();

    // Tạo đơn hàng
    $stmt = $pdo->prepare("INSERT INTO orders (order_date, customer_name, note) VALUES (CURDATE(), ?, ?)");
    $stmt->execute([$order[0], $order[1]]);
    $order_id = $pdo->lastInsertId();

    // Thêm từng sản phẩm
    foreach ($order[2] as $item) {
        // Lấy giá hiện tại
        $stmt = $pdo->prepare("SELECT unit_price FROM products WHERE id = ?");
        $stmt->execute([$item["product_id"]]);
        $unit_price = $stmt->fetchColumn();

        // Chèn vào order_items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_order_time)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item["product_id"], $item["quantity"], $unit_price]);
    }

    $pdo->commit();
}

echo "Đã thêm 3 đơn hàng mẫu.";