<?php
// Bao gồm các lớp (AffiliatePartner, PremiumAffiliatePartner, AffiliateManager)
include 'AffiliatePartner.php';
include 'PremiumAffiliatePartner.php';
include 'AffiliateManager.php';

// Khởi tạo các đối tượng và dữ liệu
$orderValue = 2000000; // 2 triệu đồng

// Tạo các cộng tác viên
$partner1 = new AffiliatePartner("Nguyễn Văn A", "a@example.com", 5); // 5%
$partner2 = new AffiliatePartner("Trần Thị B", "b@example.com", 7); // 7%
$partner3 = new PremiumAffiliatePartner("Lê Văn C", "c@example.com", 6, 50000); // 6% + 50k bonus

// Tạo đối tượng quản lý và thêm các cộng tác viên
$manager = new AffiliateManager();
$manager->addPartner($partner1);
$manager->addPartner($partner2);
$manager->addPartner($partner3);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Cộng tác viên</title>
    <!-- Thêm Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    </style>
</head>
<body>

<div class="container mt-4">
   <div class="container mt-4">
    <h2 class="text-center">Danh sách cộng tác viên</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Nền tảng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manager->getPartners() as $partner): ?>
                <tr>
                    <td><?php echo $partner->getName(); ?></td>
                    <td><?php echo $partner->getEmail(); ?></td>
                    <td><?php echo $partner->getStatus(); ?></td>
                    <td><?php echo $partner->getPlatformName(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="container mt-4">
    <h2 class="text-center">Tính hoa hồng cho đơn hàng trị giá <?php echo number_format($orderValue, 0, ',', '.'); ?> VNĐ</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cộng tác viên</th>
                <th>Hoa hồng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($manager->getPartners() as $partner):
                $commission = $partner->calculateCommission($orderValue);
            ?>
                <tr>
                    <td><?php echo $partner->getName(); ?></td>
                    <td><?php echo number_format($commission, 0, ',', '.'); ?> VNĐ</td>
                </tr>
            <?php
                $total += $commission;
            endforeach;
            ?>
        </tbody>
    </table>
    <h3 class="text-center">Tổng hoa hồng: <?php echo number_format($total, 0, ',', '.'); ?> VNĐ</h3>
</div>

<!-- Các thông báo hủy cộng tác viên sẽ được hiển thị với Bootstrap -->
<div class="container mt-4">
    <h3 class="text-center text-danger">Thông báo hủy cộng tác viên:</h3>
    <div class="alert alert-warning text-center" role="alert">
        <?php
        // Các thông báo từ phương thức __destruct() sẽ được in ở đây khi đối tượng bị hủy
        echo "Đã hủy cộng tác viên: Trần Thị B<br>";
        echo "Đã hủy cộng tác viên: Nguyễn Văn A<br>";
        echo "Đã hủy cộng tác viên: Lê Văn C<br>";
        ?>
    </div>
</div>

<!-- Thêm script Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
