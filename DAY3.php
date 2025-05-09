<?php
define('STANDARD_DAYS', 22);

// Dữ liệu
$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 5000000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 6000000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 5500000],
];

$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
];

$adjustments = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 300000, 'deduction' => 100000],
    103 => ['allowance' => 400000, 'deduction' => 150000],
];

// Xử lý bảng lương
$report = [];
$total = 0;

foreach ($employees as $emp) {
    $id = $emp['id'];
    $name = $emp['name'];
    $base = $emp['base_salary'];
    $days = isset($timesheet[$id]) ? count($timesheet[$id]) : 0;
    $allowance = $adjustments[$id]['allowance'] ?? 0;
    $deduction = $adjustments[$id]['deduction'] ?? 0;
    $net = round(($base / STANDARD_DAYS) * $days + $allowance - $deduction);
    $total += $net;

    $report[] = [
        'id' => $id,
        'name' => $name,
        'days' => $days,
        'base' => $base,
        'allowance' => $allowance,
        'deduction' => $deduction,
        'net' => $net
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bảng Lương</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bảng Lương Nhân Viên</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Mã NV</th>
                <th>Họ tên</th>
                <th>Ngày công</th>
                <th>Lương cơ bản</th>
                <th>Phụ cấp</th>
                <th>Khấu trừ</th>
                <th>Lương thực lĩnh</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['days'] ?></td>
                    <td><?= number_format($row['base']) ?> VND</td>
                    <td><?= number_format($row['allowance']) ?> VND</td>
                    <td><?= number_format($row['deduction']) ?> VND</td>
                    <td><?= number_format($row['net']) ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <strong>Tổng quỹ lương:</strong> <?= number_format($total) ?> VND
    </div>
</div>
</body>
</html>
