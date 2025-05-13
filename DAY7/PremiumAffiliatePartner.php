<?php
class PremiumAffiliatePartner extends AffiliatePartner {
    private float $bonusPerOrder;

    public function __construct(
        string $name, 
        string $email, 
        float $commissionRate, 
        float $bonusPerOrder, 
        bool $isActive = true
    ) {
        parent::__construct($name, $email, $commissionRate, $isActive);
        $this->bonusPerOrder = $bonusPerOrder;
    }

    // Override: tính hoa hồng = phần trăm + bonus
    public function calculateCommission(float $orderValue): float {
        return parent::calculateCommission($orderValue) + $this->bonusPerOrder;
    }
}
?>
