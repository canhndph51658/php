<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO products (product_name, unit_price, stock_quantity) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['stock']]);
    header("Location: index.php");
}   
?>
<form method="post" class="container py-4">
    <h2>➕ Thêm sản phẩm</h2>
    <input class="form-control mb-2" name="name" placeholder="Tên sản phẩm" required>
    <input class="form-control mb-2" name="price" type="number" placeholder="Giá" required>
    <input class="form-control mb-2" name="stock" type="number" placeholder="Tồn kho" required>
    <button class="btn btn-success">Lưu</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
