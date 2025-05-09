<?php
// Khai báo tỷ lệ hoa hồng và thuế
define("TY_LE_HOA_HONG", 0.2); // 20%
define("TY_LE_THUE_VAT", 0.1); // 10%

// Thông tin chiến dịch
$ten_chien_dich = "Spring Sale 2025";
$so_luong_sp = 150;
$gia_sp = 99.99;
$da_ket_thuc = true;
$loai_sp = "Thời trang";

// Danh sách các đơn hàng (mã đơn => số tiền)
$don_hang = [
    "ID001" => 99.99,
    "ID002" => 49.99,
    "ID003" => 149.99,
    "ID004" => 199.99,
    "ID005" => 59.99
];

// Tính tổng doanh thu
$tong_tien = 0;
foreach ($don_hang as $ma => $tien) {
    $tong_tien += $tien;
}

// Tính hoa hồng và thuế
$tien_hoa_hong = $tong_tien * TY_LE_HOA_HONG;
$tien_thue = $tong_tien * TY_LE_THUE_VAT;

// Tính lợi nhuận
$loi_nhuan = $tong_tien - $tien_hoa_hong - $tien_thue;

// Đánh giá kết quả chiến dịch
if ($loi_nhuan > 0) {
    $danh_gia = "Chiến dịch thành công";
} elseif ($loi_nhuan == 0) {
    $danh_gia = "Chiến dịch hòa vốn";
} else {
    $danh_gia = "Chiến dịch lỗ";
}

// Thông báo theo loại sản phẩm
$thong_bao = "";
switch ($loai_sp) {
    case "Điện tử":
        $thong_bao = "Loại Điện tử bán khá chạy.";
        break;
    case "Thời trang":
        $thong_bao = "Thời trang đang có doanh thu ổn định.";
        break;
    case "Gia dụng":
        $thong_bao = "Gia dụng được nhiều người quan tâm.";
        break;
    default:
        $thong_bao = "Chưa có thông tin loại sản phẩm.";
}

// In ra kết quả
echo "Tên chiến dịch: $ten_chien_dich<br>";
echo "Trạng thái: " . ($da_ket_thuc ? "Đã kết thúc" : "Đang chạy") . "<br>";
echo "Tổng doanh thu: " . number_format($tong_tien, 2) . " USD<br>";
echo "Tiền hoa hồng: " . number_format($tien_hoa_hong, 2) . " USD<br>";
echo "Thuế VAT: " . number_format($tien_thue, 2) . " USD<br>";
echo "Lợi nhuận: " . number_format($loi_nhuan, 2) . " USD<br>";
echo "Đánh giá: $danh_gia<br>";
echo "Thông báo: $thong_bao<br>";

// Chi tiết từng đơn hàng
echo "<br>--- Chi tiết đơn hàng ---<br>";
foreach ($don_hang as $ma => $tien) {
    echo "Đơn $ma: " . number_format($tien, 2) . " USD<br>";
}

// Thông tin debug
echo "<br><strong>Thông tin hệ thống:</strong><br>";
echo "Tên file: " . basename(__FILE__) . "<br>";
echo "Dòng hiện tại: " . __LINE__;
?>
