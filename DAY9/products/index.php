<?php require '../db.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách sản phẩm | TechFactory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">TechFactory</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a href="../orders/index.php" class="nav-link">📑 Đơn hàng</a></li>
                <li class="nav-item"><a href="index.php" class="nav-link active">📦 Sản phẩm</a></li>
            </ul>
            <a href="add.php" class="btn btn-light">+ Thêm sản phẩm</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Danh sách sản phẩm</h2>

    <div class="mb-3">
        <span class="fw-semibold me-2">Bộ lọc:</span>
        <a href="?filter=all" class="btn btn-outline-primary btn-sm <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'active' : '' ?>">Tất cả</a>
        <a href="?filter=expensive" class="btn btn-outline-primary btn-sm <?= (isset($_GET['filter']) && $_GET['filter'] === 'expensive') ? 'active' : '' ?>">Giá > 1.000.000 đ</a>
        <a href="?filter=sorted" class="btn btn-outline-primary btn-sm <?= (isset($_GET['filter']) && $_GET['filter'] === 'sorted') ? 'active' : '' ?>">Giá giảm dần</a>
        <a href="?filter=latest" class="btn btn-outline-primary btn-sm <?= (isset($_GET['filter']) && $_GET['filter'] === 'latest') ? 'active' : '' ?>">5 sản phẩm mới</a>
    </div>

    <?php
    $filter = $_GET['filter'] ?? 'all';

    switch ($filter) {
        case 'expensive':
            $stmt = $pdo->query("SELECT * FROM products WHERE unit_price > 1000000");
            break;
        case 'sorted':
            $stmt = $pdo->query("SELECT * FROM products ORDER BY unit_price DESC");
            break;
        case 'latest':
            $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 5");
            break;
        default:
            $stmt = $pdo->query("SELECT * FROM products");
            break;
    }

    $products = $stmt->fetchAll();
    ?>

    <table class="table table-striped table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th scope="col" style="width: 5%;">ID</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col" style="width: 15%;">Giá</th>
                <th scope="col" style="width: 10%;">Tồn kho</th>
                <th scope="col" style="width: 20%;">Ngày tạo</th>
                <th scope="col" style="width: 20%;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) === 0): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Không có sản phẩm nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                        <td><?= number_format($p['unit_price'], 0, ',', '.') ?> đ</td>
                        <td><?= htmlspecialchars($p['stock_quantity']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($p['created_at']))) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
