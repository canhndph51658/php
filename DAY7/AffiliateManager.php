<?php
class AffiliateManager {
    private array $partners = [];

    // Thêm cộng tác viên vào danh sách
    public function addPartner(AffiliatePartner $affiliate): void {
        $this->partners[] = $affiliate;
    }

    // Phương thức để lấy danh sách các cộng tác viên
    public function getPartners(): array {
        return $this->partners;
    }

    // Tính tổng hoa hồng của tất cả cộng tác viên với 1 đơn hàng mỗi người
    public function totalCommission(float $orderValue): float {
        $total = 0;
        foreach ($this->partners as $partner) {
            $commission = $partner->calculateCommission($orderValue);
            echo "Hoa hồng của {$partner->getName()} là: " 
                . number_format($commission, 0, ',', '.') . " VNĐ<br>";
            $total += $commission;
        }
        return $total;
    }
}

?>
