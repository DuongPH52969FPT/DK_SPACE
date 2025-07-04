<?php
include 'sql/connect.php';
//Phân tích doanh thu: Tính tổng doanh thu từ các đơn hàng completed, nhóm theo danh mục sản phẩm.

function RevenueByCategory($conn)
{
    $sql = "
        SELECT 
    products.category,
    SUM(orderitems.quantity * products.price) AS total_revenue
FROM 
    orders
JOIN 
    orderitems ON orders.order_id = orderitems.order_id
JOIN 
    products ON orderitems.product_id = products.product_id
WHERE 
    orders.status = 'completed'
GROUP BY 
    products.category
ORDER BY 
    total_revenue DESC;

    ";

    try {
        $result = $conn->query($sql);

        echo "<h3>Tổng doanh thu theo danh mục (đơn hàng đã hoàn tất):</h3>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "<strong>Danh mục:</strong> " . htmlspecialchars($row['category']) . "<br>";
            echo "<strong>Doanh thu:</strong> " . number_format($row['total_revenue'], 0, ',', '.') . " VND";
            echo "<hr>";
            echo "</p>";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
//Người dùng giới thiệu: Tạo danh sách các người dùng kèm theo tên người giới thiệu (dùng self join).
function listUsersWithReferrer($conn)
{
    $sql = "SELECT users.user_id, users.full_name, referrers.full_name AS referrer_name
            FROM users
            LEFT JOIN users AS referrers ON users.referrer_id = referrers.user_id";
    foreach ($conn->query($sql) as $row) {
        echo "<p><strong>{$row['full_name']}</strong> được giới thiệu bởi: {$row['referrer_name']}</p>";
    }
}
//Sản phẩm không còn bán: Tìm các sản phẩm đã từng được đặt mua nhưng hiện tại không còn active.
function inactiveUsers($conn)
{
    $sql = "SELECT users.*
            FROM users
            LEFT JOIN orders ON users.user_id = orders.user_id
            WHERE orders.order_id IS NULL";
    foreach ($conn->query($sql) as $row) {
        echo "<p>Người dùng: <strong>{$row['full_name']}</strong> (ID: {$row['user_id']}) chưa từng đặt hàng.</p>";
    }
}
//Đơn hàng đầu tiên của từng người dùng: Với mỗi user, tìm order_id tương ứng với đơn hàng đầu tiên của họ.

function firstOrdersPerUser($conn)
{
    $sql = "SELECT o.user_id, o.order_id, o.order_date
            FROM orders o
            JOIN (
                SELECT user_id, MIN(order_date) AS first_order_date
                FROM orders GROUP BY user_id
            ) sub ON o.user_id = sub.user_id AND o.order_date = sub.first_order_date";
    foreach ($conn->query($sql) as $row) {
        echo "<p>Người dùng ID: {$row['user_id']} - Đơn hàng đầu tiên: {$row['order_id']} ngày {$row['order_date']}</p>";
    }
}
//Tổng chi tiêu của mỗi người dùng: Viết truy vấn lấy tổng tiền mà từng người dùng đã chi tiêu (chỉ tính đơn hàng completed).

function totalSpentByUsers($conn)
{
    $sql = "SELECT users.user_id, users.full_name, 
                   SUM(orderitems.quantity * products.price) AS total_spent
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            JOIN orderitems ON orders.order_id = orderitems.order_id
            JOIN products ON orderitems.product_id = products.product_id
            WHERE orders.status = 'completed'
            GROUP BY users.user_id, users.full_name";
    foreach ($conn->query($sql) as $row) {
        echo "<p>{$row['full_name']} đã chi tiêu: <strong>" . number_format($row['total_spent']) . "₫</strong></p>";
    }
}
//Lọc người dùng tiêu nhiều: Từ kết quả trên, chỉ lấy các user có tổng chi tiêu > 25 triệu.
function bigSpenders($conn)
{
    $sql = "SELECT users.user_id, users.full_name, 
                   SUM(orderitems.quantity * products.price) AS total_spent
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            JOIN orderitems ON orders.order_id = orderitems.order_id
            JOIN products ON orderitems.product_id = products.product_id
            WHERE orders.status = 'completed'
            GROUP BY users.user_id, users.full_name
            HAVING total_spent > 25000000";
    foreach ($conn->query($sql) as $row) {
        echo "<p><strong>{$row['full_name']}</strong> đã chi tiêu: " . number_format($row['total_spent']) . "₫</p>";
    }
}
//So sánh các thành phố: Tính tổng số đơn hàng và tổng doanh thu của từng thành phố.
function ordersAndRevenueByCity($conn)
{
    $sql = "SELECT users.city,
                   COUNT(DISTINCT orders.order_id) AS total_orders,
                   SUM(orderitems.quantity * products.price) AS total_revenue
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            JOIN orderitems ON orders.order_id = orderitems.order_id
            JOIN products ON orderitems.product_id = products.product_id
            WHERE orders.status = 'completed'
            GROUP BY users.city";
    foreach ($conn->query($sql) as $row) {
        echo "<p><strong>{$row['city']}</strong>: {$row['total_orders']} đơn, Doanh thu: " . number_format($row['total_revenue']) . "₫</p>";
    }
}
//Người dùng có ít nhất 2 đơn hàng completed: Truy xuất danh sách người dùng thỏa điều kiện.
function usersWithMultipleCompletedOrders($conn)
{
    $sql = "SELECT users.user_id, users.full_name, COUNT(orders.order_id) AS completed_orders
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            WHERE orders.status = 'completed'
            GROUP BY users.user_id, users.full_name
            HAVING completed_orders >= 2";
    foreach ($conn->query($sql) as $row) {
        echo "<p><strong>{$row['full_name']}</strong> có {$row['completed_orders']} đơn completed.</p>";
    }
}
//Tìm đơn hàng có sản phẩm thuộc nhiều hơn 1 danh mục: (gợi ý: JOIN OrderItems và Products rồi GROUP BY order_id + COUNT DISTINCT category > 1).
function ordersWithMultipleCategories($conn)
{
    $sql = "SELECT orders.order_id
            FROM orders
            JOIN orderitems ON orders.order_id = orderitems.order_id
            JOIN products ON orderitems.product_id = products.product_id
            GROUP BY orders.order_id
            HAVING COUNT(DISTINCT products.category) > 1";
    foreach ($conn->query($sql) as $row) {
        echo "<p>Đơn hàng ID: <strong>{$row['order_id']}</strong> có sản phẩm thuộc nhiều danh mục.</p>";
    }
}
//Kết hợp danh sách: Dùng UNION để kết hợp 2 danh sách:
function combinedUserList($conn)
{
    $sql = "SELECT users.user_id, users.full_name, 'placed_order' AS source
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            UNION
            SELECT users.user_id, users.full_name, 'referred' AS source
            FROM users
            WHERE users.referrer_id IS NOT NULL";
    foreach ($conn->query($sql) as $row) {
        echo "<p>{$row['full_name']} đến từ: <strong>{$row['source']}</strong></p>";
    }
}

RevenueByCategory($conn);
