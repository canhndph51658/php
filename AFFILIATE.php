<?php

// ====== 1. DANH SÁCH NGƯỜI DÙNG ======
$users = [
    1 => ['name' => 'Alice', 'referrer_id' => null],
    2 => ['name' => 'Bob', 'referrer_id' => 1],
    3 => ['name' => 'Charlie', 'referrer_id' => 2],
    4 => ['name' => 'David', 'referrer_id' => 3],
    5 => ['name' => 'Eva', 'referrer_id' => 1],
];

// ====== 2. DANH SÁCH ĐƠN HÀNG ======
$orders = [
    ['order_id' => 101, 'user_id' => 4, 'amount' => 200],
    ['order_id' => 102, 'user_id' => 3, 'amount' => 150],
    ['order_id' => 103, 'user_id' => 5, 'amount' => 300],
];

// ====== 3. TỶ LỆ HOA HỒNG THEO CẤP ======
$commissionRates = [
    1 => 0.10, // Cấp 1: 10%
    2 => 0.05, // Cấp 2: 5%
    3 => 0.02, // Cấp 3: 2%
];

// ====== 4. BIẾN LƯU KẾT QUẢ ======
$tongHoaHong = [];
$chiTietHoaHong = [];

// ====== 5. HÀM TÌM NGƯỜI GIỚI THIỆU THEO CẤP ======
function timNguoiGioiThieu($userId, $users, $soCap = 3) {
    $ketQua = [];
    $hienTai = $userId;
    $cap = 1;

    while ($cap <= $soCap) {
        if (!isset($users[$hienTai])) break;

        $nguoiTren = $users[$hienTai]['referrer_id'];

        if ($nguoiTren === null) break;

        $ketQua[$cap] = $nguoiTren;

        $hienTai = $nguoiTren;
        $cap++;
    }

    return $ketQua;
}

// ====== 6. HÀM XỬ LÝ MỖI ĐƠN HÀNG ======
function xuLyDonHang($donHang, $users, $commissionRates) {
    global $tongHoaHong, $chiTietHoaHong;

    $nguoiMua = $donHang['user_id'];
    $soTien = $donHang['amount'];
    $maDon = $donHang['order_id'];

    $nguoiGioiThieu = timNguoiGioiThieu($nguoiMua, $users);

    foreach ($nguoiGioiThieu as $cap => $idNguoiTren) {
        $tyLe = isset($commissionRates[$cap]) ? $commissionRates[$cap] : 0;
        $hoaHong = $soTien * $tyLe;

        if (!isset($tongHoaHong[$idNguoiTren])) {
            $tongHoaHong[$idNguoiTren] = 0;
        }

        $tongHoaHong[$idNguoiTren] += $hoaHong;

        $chiTietHoaHong[] = [
            'tenNguoiNhan' => $users[$idNguoiTren]['name'],
            'tenNguoiMua' => $users[$nguoiMua]['name'],
            'maDon' => $maDon,
            'cap' => $cap,
            'soTien' => $hoaHong
        ];
    }
}

// ====== 7. CHẠY QUA TẤT CẢ ĐƠN HÀNG ======
foreach ($orders as $don) {
    xuLyDonHang($don, $users, $commissionRates);
}

// ====== 8. IN TỔNG HOA HỒNG ======
echo "<h3>TỔNG HOA HỒNG CỦA MỖI NGƯỜI:</h3>";
foreach ($tongHoaHong as $id => $tong) {
    $ten = $users[$id]['name'];
    echo "$ten nhận được: " . number_format($tong, 2) . " đ<br>";
}

// ====== 9. IN CHI TIẾT TỪNG HOA HỒNG ======
echo "<h3>CHI TIẾT HOA HỒNG:</h3>";
foreach ($chiTietHoaHong as $dong) {
    echo "{$dong['tenNguoiNhan']} nhận " . number_format($dong['soTien'], 2) . " đ ";
    echo "từ đơn hàng #{$dong['maDon']} của {$dong['tenNguoiMua']} (Cấp {$dong['cap']})<br>";
}
?>
