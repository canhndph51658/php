<?php require '../db.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách đơn hàng | TechFactory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">TechFactory</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a href="index.php" class="nav-link active">📑 Đơn hàng</a></li>
                <li class="nav-item"><a href="../products/index.php" class="nav-link">📦 Sản phẩm</a></li>
            </ul>
            <a href="add_item.php" class="btn btn-light">+ Thêm đơn hàng</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Danh sách đơn hàng</h2>

    <table class="table table-striped table-hover align-middle">
        <thead class="table-primary">
            <tr>
                <th scope="col" style="width: 5%;">ID</th>
                <th scope="col" style="width: 20%;">Khách hàng</th>
                <th scope="col" style="width: 15%;">Ngày đặt</th>
                <th scope="col">Ghi chú</th>
                <th scope="col" style="width: 15%;">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("
                SELECT o.*, IFNULL(SUM(oi.quantity * oi.price_at_order_time), 0) AS total
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                GROUP BY o.id
                ORDER BY o.order_date DESC
            ");
            $orders = $stmt->fetchAll();

            if (count($orders) === 0):
            ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['order_date'])) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['note'])) ?></td>
                        <td><?= number_format($row['total'], 0, ',', '.') ?> đ</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
