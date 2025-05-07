<?php
// Định nghĩa hằng số
define("COMMISSION_RATE", 0.2); // Tỷ lệ hoa hồng 20%
define("VAT_RATE", 0.1);        // Thuế VAT 10%

// Dữ liệu chiến dịch
$name = "Spring Sale 2025";  // Tên chiến dịch
$count = 150;                   // Số lượng đơn hàng
$price = 99.99;               // Giá sản phẩm
$status = true;              // Trạng thái chiến dịch: Kết thúc
$type = "Thời trang";         // Loại sản phẩm
$list = [                       // Danh sách đơn hàng
    "ID001" => 99.99,
    "ID002" => 49.99,
    "ID003" => 149.99,
    "ID004" => 199.99,
    "ID005" => 59.99
];

// Tính toán doanh thu tổng cộng
$total = 0;
foreach ($list as $id => $price) {
    $total += $price; // Cộng dồn giá trị của mỗi đơn hàng vào tổng doanh thu
}

// Tính toán chi phí hoa hồng
$cost = $total * COMMISSION_RATE;  // Hoa hồng = Doanh thu * Tỷ lệ hoa hồng

// Tính toán thuế VAT
$vat = $total * VAT_RATE;  // Thuế VAT = Doanh thu * Tỷ lệ thuế VAT

// Tính lợi nhuận
$profit = $total - $cost - $vat; // Lợi nhuận = Doanh thu - Chi phí hoa hồng - Thuế VAT

// Đánh giá hiệu quả chiến dịch
if ($profit > 0) {
    $result = "Chiến dịch thành công"; // Nếu lợi nhuận > 0
} elseif ($profit == 0) {
    $result = "Chiến dịch hòa vốn"; // Nếu lợi nhuận = 0
} else {
    $result = "Chiến dịch thất bại"; // Nếu lợi nhuận < 0
}   

// Thông báo về loại sản phẩm
$message = "";
switch ($type) {
    case "Điện tử":
        $message = "Sản phẩm Điện tử có doanh thu tốt";
        break;
    case "Thời trang":
        $message = "Sản phẩm Thời trang có doanh thu ổn định";
        break;
    case "Gia dụng":
        $message = "Sản phẩm Gia dụng đang được ưa chuộng";
        break;
    default:
        $message = "Sản phẩm chưa xác định";
}

// In kết quả
echo "Chiến dịch: $name<br>";
echo "Trạng thái chiến dịch: " . ($status ? "Kết thúc" : "Đang chạy") . "<br>";
echo "Doanh thu: " . number_format($total, 2) . " USD<br>";
echo "Chi phí hoa hồng: " . number_format($cost, 2) . " USD<br>";
echo "Thuế VAT: " . number_format($vat, 2) . " USD<br>";
echo "Lợi nhuận: " . number_format($profit, 2) . " USD<br>";
echo "Đánh giá: $result<br>";
echo "Thông báo về sản phẩm: $message<br>";

// In chi tiết đơn hàng
echo "<br>Chi tiết từng đơn hàng:<br>";
foreach ($list as $id => $item) {
    echo "Đơn hàng ID: $id, Giá trị: " . number_format($item, 2) . " USD<br>";
}

// Debug thông tin file và dòng
echo "<br><strong>Debug Information:</strong><br>";     
echo "Tên file hiện tại: " . __FILE__ . "<br>";
echo "Dòng mã hiện tại: " . __LINE__;
?>
