<?php

class AffiliatePartner {

    const PLATFORM_NAME = "VietLink Affiliate";


    protected string $name;
    protected string $email;
    protected float $commissionRate;
    protected bool $isActive;

    // Constructor
    public function __construct(string $name, string $email, float $commissionRate, bool $isActive = true) {
        $this->name = $name;
        $this->email = $email;
        $this->commissionRate = $commissionRate;
        $this->isActive = $isActive;
    }

    // Destructor
    // public function __destruct() {
    //     echo "[LOG] Đã huỷ cộng tác viên: {$this->name}\n";
    // }

    // Tính hoa hồng = tỷ lệ * giá trị đơn hàng
    public function calculateCommission(float $orderValue): float {
        return $orderValue * ($this->commissionRate / 100);
    }


    public function getSummary(): string {
        return "<strong>Tên</strong>: {$this->name} <br> <strong>Email</strong>: {$this->email} <br> <strong>Tỷ lệ hoa hồng</strong>: {$this->commissionRate}% <br>";
    }
}