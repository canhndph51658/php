<?php
class AffiliatePartner {
    protected string $name;
    protected string $email;
    protected float $commissionRate;
    protected bool $isActive;

    const PLATFORM_NAME = "VietLink Affiliate";

    // Constructor
    public function __construct(
        string $name, 
        string $email, 
        float $commissionRate, 
        bool $isActive = true
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->commissionRate = $commissionRate;
        $this->isActive = $isActive;
    }

    // Getter methods
    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getStatus(): string {
        return $this->isActive ? 'Đang hoạt động' : 'Ngừng hoạt động';
    }

    public function getPlatformName(): string {
        return self::PLATFORM_NAME;
    }

    // Destructor
public function __destruct() {
}

    // Tính hoa hồng dựa trên giá trị đơn hàng
    public function calculateCommission(float $orderValue): float {
        return ($this->commissionRate / 100) * $orderValue;
    }

    // Trả về thông tin tổng quan
    public function getSummary(): string {
        return "Tên: {$this->name}, Email: {$this->email}, "
            . "Trạng thái: " . ($this->isActive ? "Đang hoạt động" : "Ngừng hoạt động") . ", "
            . "Nền tảng: " . self::PLATFORM_NAME;
    }
}
?>
