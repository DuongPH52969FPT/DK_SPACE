<?php

class PremiumAffiliatePartner extends AffiliatePartner {
    protected float $bonusPerOrder;

    public function __construct(string $name, string $email, float $commissionRate, float $bonusPerOrder, bool $isActive = true) {
        parent::__construct($name, $email, $commissionRate, $isActive);
        $this->bonusPerOrder = $bonusPerOrder;
    }

    // Override: tính hoa hồng = tỷ lệ + bonus cố định
    public function calculateCommission(float $orderValue): float {
        return parent::calculateCommission($orderValue) + $this->bonusPerOrder;
    }

    // Override (tùy chọn nếu muốn hiển thị rõ là loại cao cấp)
    public function getSummary(): string {
        return parent::getSummary() . "Loại: Premium, Thưởng/đơn: " . number_format($this->bonusPerOrder, 0) . " VNĐ <br>";
    }
}