<?php


echo "<h1>HỆ THỐNG TÍNH HOA HỒNG AFFILIATE ĐA CẤP</h1>";

$users = [
    ['id' => 1, 'name' => 'Alice', 'referrer_id' => null],
    ['id' => 2, 'name' => 'Bob', 'referrer_id' => 1],
    ['id' => 3, 'name' => 'Charlie', 'referrer_id' => 2],
    ['id' => 4, 'name' => 'David', 'referrer_id' => 3],
    ['id' => 5, 'name' => 'Eva', 'referrer_id' => 1],
];

$orders = [
    ['order_id' => 101, 'user_id' => 4, 'amount' => 200.0], // David
    ['order_id' => 102, 'user_id' => 3, 'amount' => 150.0], // Charlie
    ['order_id' => 103, 'user_id' => 5, 'amount' => 300.0], // Eva
];


$commissionRates = [
    1 => 0.10, // 10% cho người giới thiệu trực tiếp
    2 => 0.05, // 5% cho người giới thiệu cấp 2
    3 => 0.02, // 2% cho người giới thiệu cấp 3
];

function UserLookup($users)
{
    $lookup = [];
    foreach ($users as $user) {
        $lookup[$user['id']] = $user;
    }
    return $lookup;
}

// $userLookup = UserLookup($users);
// $userLookup[2];
function calculateCommission(array $orders, array $users, array $commissionRates): array
{
    $userLookup = UserLookup($users); // Tạo mảng tra cứu người dùng
    $commissions = []; // Lưu tổng hoa hồng
    $commissionDetails = []; // Lưu chi tiết hoa hồng

    foreach ($orders as $order) {
        $userId = $order['user_id'];
        $amount = $order['amount'];
        $referrerId = $userLookup[$userId]['referrer_id'] ?? null;

        $level = 1;

        // Tính hoa hồng cho từng cấp
        while ($referrerId !== null && isset($commissionRates[$level])) {
            $commission = $amount * $commissionRates[$level];

            // Cộng dồn hoa hồng
            if (!isset($commissions[$referrerId])) {
                $commissions[$referrerId] = 0;
            }
            $commissions[$referrerId] += $commission;

            // Lưu chi tiết hoa hồng
            $commissionDetails[] = [
                'referrer_id' => $referrerId,
                'order_id' => $order['order_id'],
                'buyer_id' => $userId,
                'level' => $level,
                'commission' => $commission,
            ];

            // Lấy người giới thiệu cấp trên
            $referrerId = $userLookup[$referrerId]['referrer_id'] ?? null;
            $level++;
        }
    }

    return ['totals' => $commissions, 'details' => $commissionDetails];
}

$result = calculateCommission($orders, $users, $commissionRates); // Gọi hàm và lưu kết quả

echo "<h2>Danh sách hoa hồng</h2>";
echo "<table border='1'>";
echo "<tr><th>Tên người dùng</th><th>Tổng hoa hồng nhận được</th></tr>";

foreach ($users as $user) {
    $userId = $user['id'];
    $userName = $user['name'];
    $commission = isset($result['totals'][$userId]) ? $result['totals'][$userId] : 0; // Lấy từ mảng 'totals'
    echo "<tr><td>$userName</td><td>" . number_format($commission, 2) . "</td></tr>";
}
echo "</table>";

$userLookup = UserLookup($users);

echo "<h2>Chi tiết hoa hồng</h2>";
echo "<table border='1'>";
echo "<tr>
        <th>Đơn hàng</th>
        <th>Người mua</th>
        <th>Người nhận hoa hồng</th>
        <th>Cấp hoa hồng</th>
        <th>Số tiền hoa hồng</th>
      </tr>";
foreach ($result['details'] as $detail) {
    $orderId = $detail['order_id'];
    $buyerName = $userLookup[$detail['buyer_id']]['name'];
    $referrerName = $userLookup[$detail['referrer_id']]['name'];
    $level = $detail['level'];
    $commissionAmount = number_format($detail['commission'], 2);

    echo "<tr>
            <td>$orderId</td>
            <td>$buyerName</td>
            <td>$referrerName</td>
            <td>$level</td>
            <td>$commissionAmount</td>
          </tr>";
}
echo "</table>";
