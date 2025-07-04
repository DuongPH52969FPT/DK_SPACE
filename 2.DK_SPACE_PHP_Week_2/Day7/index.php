<?php




require "classes/AffiliateManager.php";
require "classes/AffiliatePartner.php";
require "classes/PremiumAffiliatePartner.php";


echo "<h2>Dự án: Xây dựng mô-đun quản lý cộng tác viên (Affiliate Management - MVP)</h2> <br>";

// Đơn hàng trị giá
$orderValue = 2000000;

// Khởi tạo cộng tác viên
$ctv1 = new AffiliatePartner("Nguyễn Văn A", "a@example.com", 5);      
$ctv2 = new PremiumAffiliatePartner("Lê Hoàng C", "c@example.com", 6, 100000);

// Quản lý cộng tác viên
$manager = new AffiliateManager();
$manager->addPartner($ctv1);
$manager->addPartner($ctv2);

// In thông tin cộng tác viên
echo "DANH SÁCH CỘNG TÁC VIÊN<br>";
$manager->listPartners();

echo "<strong>TÍNH HOA HỒNG CHO ĐƠN HÀNG GIÁ TRỊ:</strong> <br> " . number_format($orderValue, 0) . " VNĐ";
$total = $manager->totalCommission($orderValue);
echo "<strong>Tổng hoa hồng toàn hệ thống cần chi trả</strong>: " . number_format($total, 0) . " VNĐ <br>";

?>
