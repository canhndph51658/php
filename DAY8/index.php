<?php

require_once __DIR__ . '/vendor/autoload.php';

use XYZBank\Accounts\SavingsAccount;
use XYZBank\Accounts\CheckingAccount;
use XYZBank\Accounts\AccountCollection;
use XYZBank\Accounts\Bank;

// Khởi tạo tài khoản
$savings = new SavingsAccount('SAV001', 'Nguyễn Thị A', 20000000);
$checking1 = new CheckingAccount('CHK001', 'Lê Văn B', 8000000);
$checking2 = new CheckingAccount('CHK002', 'Trần Minh C', 12000000);

// Giao dịch
$checking1->deposit(5000000);
$checking2->withdraw(2000000);

// Tính lãi
$interest = $savings->calculateAnnualInterest();

// Quản lý danh sách
$collection = new AccountCollection();
$collection->addAccount($savings);
$collection->addAccount($checking1);
$collection->addAccount($checking2);

// Bắt đầu HTML với Bootstrap
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống ngân hàng XYZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4 text-primary">Thông tin tài khoản</h1>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($collection as $account): ?>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $account->getAccountType(); ?>: <?= $account->getOwnerName(); ?></h5>
                        <p class="card-text">
                            <strong>Mã số:</strong> <?= $account->getAccountNumber(); ?><br>
                            <strong>Số dư:</strong> <?= number_format($account->getBalance(), 0, ',', '.') ?> VNĐ
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <hr class="my-4">

    <h2 class="text-success">Lãi suất tài khoản tiết kiệm</h2>
    <p><?= number_format($interest, 0, ',', '.') ?> VNĐ / năm</p>

    <hr class="my-4">

    <h2 class="text-warning">Giao dịch đã thực hiện</h2>
    <div class="bg-dark text-white p-3 rounded">
        <pre class="m-0"><?= htmlspecialchars(implode("\n", $savings->getLogs() + $checking1->getLogs() + $checking2->getLogs())); ?></pre>
    </div>

    <hr class="my-4">

<p class="text-muted">Tổng số tài khoản đã khởi tạo: <?= Bank::getTotalAccounts(); ?></p>
    <p class="text-muted">Tên ngân hàng: <?= Bank::getBankName(); ?></p>
</div>
</body>
</html>
