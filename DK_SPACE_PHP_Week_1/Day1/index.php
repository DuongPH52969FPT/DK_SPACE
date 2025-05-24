<?php



echo "<h1>Phân tích hiệu quả chiến dịch Affiliate Marketing</h1>";

const COMMISSION_RATE = 0.2; // Tỷ lệ hoa hồng 20%
const VAT_RATE = 0.1; // Tỷ lệ thuế VAT 10%

//---------------------------------------/
//Dữ liệu đầu vào
$companyName = "Spring Sale 25";


$orderQuantity = (int) "150";


$productPrice = (float) "99.99 USD";   


$productType = "Thời trang";

$status = true;


$orderList = [
    "ID001" => 99.99,
    "ID002" => 49.99,
    "ID003" => 199.99,
    "ID004" => 29.99,
    "ID005" => 109.99,
];
// echo "Danh sách đơn hàng: <br>";
// print_r($orderList); // In mảng đơn hàng

//---------------------------------------/



// Công thức tính toán
$revenue = $productPrice * $orderQuantity;

$commissionCost = $revenue * COMMISSION_RATE;

$profit = $revenue - $commissionCost - VAT_RATE;
//----------------------------------------/
//Logic
//If else xác định hiệu quả

if ($profit > 0) {
    echo "--Chiến dịch thành công-- </br>";
} elseif ($profit == 0) {
    echo "--Chiến dịch hòa vốn-- </br>";
} elseif ($profit < 0) {
    echo "--Chiến dịch thất bại-- </br>";
}

// echo "---------------------------------------- </br>";
switch ($productType) {
    case "Thời trang";
        echo "Thời trang doanh thu ổn định </br>";
        break;
    case "Điện tử";
        echo "Điện tử doanh thu ổn định </br>";
        break;
    case "Gia dụng";
        echo "Gia dụng doanh thu không ổn định </br>";
        break;
}

// //Sử dụng vòng lặp








echo "<strong> Tên chiến dịch: </strong>" . $companyName . "<br>";
echo "<strong> Trạng thái: </strong>" . ($status ? "Kết thúc" : "Hoạt động") . "<br>";
echo "<strong> Tổng doanh thu: </strong>" . number_format($revenue, 2) . " USD <br>";
echo "<strong> Chi phí hoa hồng: </strong>" . number_format($commissionCost, 2) . " USD <br>";
echo "<strong> Lợi nhuận (sau khi trừ VAT): </strong>" . number_format($profit, 2) . " USD <br>";

echo "<br>";
echo "<strong> Chi tiết từng đơn hàng: </strong> <br>";

print_r($orderList);

foreach ($orderList as $key => $value) {
    echo "ID đơn hàng: $key <br>" . "-Giá trị đơn hàng: $"  . number_format($value, 2) . "<br>";
}
echo "<strong>Thông báo: Chiến dịch . $companyName đã kết thúc với lợi nhuân . $profit USD </strong> <br>";

$totalRevenue = 0;
for ($i = 0; $i < count($orderList); $i++) {
    $values = array_values($orderList);
    $totalRevenue += $values[$i];
}
echo "\n <strong>Tổng doanh thu từ danh sách đơn (5 đơn): $ </strong>" . number_format($totalRevenue, 2) . "\n <br>";
