<?php
require '../db.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("UPDATE products SET product_name=?, unit_price=?, stock_quantity=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['stock'], $id]);
    header("Location: index.php");
}
$p = $pdo->query("SELECT * FROM products WHERE id=$id")->fetch();
?>
<form method="post" class="container py-4">
    <h2>✏️ Sửa sản phẩm</h2>
    <input class="form-control mb-2" name="name" value="<?= $p['product_name'] ?>" required>
    <input class="form-control mb-2" name="price" type="number" value="<?= $p['unit_price'] ?>" required>
    <input class="form-control mb-2" name="stock" type="number" value="<?= $p['stock_quantity'] ?>" required>
    <button class="btn btn-success">Cập nhật</button>
    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>
