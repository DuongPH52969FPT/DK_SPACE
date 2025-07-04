<?php

class AffiliateManager {
    private array $partners = [];

    // Thêm cộng tác viên
    public function addPartner(AffiliatePartner $affiliate): void {
        $this->partners[] = $affiliate;
    }

    // Liệt kê tất cả cộng tác viên
    public function listPartners(): void {
        foreach ($this->partners as $partner) {
            echo $partner->getSummary() . "<br>";
        }
    }

    // Tính tổng hoa hồng cho 1 đơn hàng của mỗi CTV
    public function totalCommission(float $orderValue): float {
        $total = 0;
        foreach ($this->partners as $partner) {
            $commission = $partner->calculateCommission($orderValue);
            echo "<br>Hoa hồng cho {$partner->getSummary()} Số tiền: " . number_format($commission, 0) . " VNĐ <br>";
            $total += $commission;
        }
        return $total;
    }
}