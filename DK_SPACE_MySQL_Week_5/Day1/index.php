<?php

include 'sql/connect.php';

echo "<h1>Thực hành SQL tổng hợp</h1>";

function HanoiCustomers($conn)
{
    $sql = "SELECT * FROM customers WHERE city = 'Hanoi'";
    try {
        $result = $conn->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "<strong>Customer ID:</strong> " . $row['customer_id'] . "<br>";
            echo "<strong>Customer Name:</strong> " . $row['name'] . "<br>";
            echo "<hr>";
            echo "</p>";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
function FilterOrders($conn)
{
    $sql = "SELECT * FROM orders WHERE total_amount > 400000 AND order_date >= '2023-01-31'";

    try {
        $resutl = $conn->query($sql);

        while ($row = $resutl->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "<strong>Order ID:</strong> " . $row['order_id'] . "<br>";
            echo "<strong>Customer ID:</strong> " . $row['customer_id'] . "<br>";
            echo "<strong>Order Date:</strong> " . $row['order_date'] . "<br>";
            echo "<strong>Total Amount:</strong> " . number_format($row['total_amount'], 0, ',', '.') . " VND<br>";
            echo "<hr>";
            echo "</p>";
        }
    } catch (PDOException $e) {
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}
function filterCustomersEmail($conn){
    $sql = "SELECT * FROM customers WHERE email IS NULL OR email = ''";

    try {

        $result = $conn->query($sql);

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo "<p>";
            echo "<strong>Customer ID:</strong> " . $row['customer_id'] . "<br>";
            echo "<strong>Name:</strong> " . $row['name'] . "<br>";
            echo "<strong>City:</strong> " . $row['city'] . "<br>";
            echo "<hr>";
            echo "</p>";
        }
        


    } catch (PDOException $e){
        echo "Lỗi truy vấn: " . $e->getMessage();
    }
}

function AllOrders($conn){
    $sql = "SELECT * FROM orders ORDER BY total_amount DESC";

    try {

        $result = $conn->query($sql);

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo "<p>";
            echo "<strong>Order ID:</strong> " . $row['order_id'] . "<br>";
            echo "<strong>Customer ID:</strong> " . $row['customer_id'] . "<br>";
            echo "<strong>Order Date:</strong> " . $row['order_date'] . "<br>";
            echo "<strong>Total Amount:</strong> " . number_format($row['total_amount'], 0, ',', '.') . " VND<br>";
            echo "<hr>";
            echo "</p>";
        }

    } catch (PDOException $e){
        echo "Lỗi truy vấn: " . $e->getMessage();
    }


    
}


function insertNewCustomer($conn) {
    $sql = "INSERT INTO customers (name, city, email) VALUES ('Pham Thanh', 'Can Tho', NULL)";

    try {
        $conn->exec($sql);
        echo "<p>Đã thêm khách hàng mới: Pham Thanh.</p><hr>";
    } catch (PDOException $e) {
        echo "Lỗi khi thêm khách hàng: " . $e->getMessage();
    }
}

function updateCustomerEmail($conn) {
    $sql = "UPDATE customers SET email = 'binh.tran@email.com' WHERE customer_id = 2";

    try {
        $conn->exec($sql);
        echo "<p>Đã cập nhật email cho khách hàng có mã là 2.</p><hr>";
    } catch (PDOException $e) {
        echo "Lỗi khi cập nhật email: " . $e->getMessage();
    }
}

function deleteOrder($conn) {
    $sql = "DELETE FROM orders WHERE order_id = 103";

    try {
        $conn->exec($sql);
        echo "<p>✅ Đã xóa đơn hàng có mã là 103.</p><hr>";
    } catch (PDOException $e) {
        echo "Lỗi khi xóa đơn hàng: " . $e->getMessage();
    }
}

function firstTwoCustomers($conn) {
    $sql = "SELECT * FROM customers LIMIT 2";

    try {
        $result = $conn->query($sql);

        echo "<h2> 2 khách hàng đầu tiên:</h2>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "<strong>ID:</strong> {$row['customer_id']}<br>";
            echo "<strong>Name:</strong> {$row['name']}<br>";
            echo "<strong>City:</strong> {$row['city']}<br>";
            echo "<strong>Email:</strong> " . ($row['email'] ?? '(trống)') . "<br>";
            echo "<hr></p>";
        }
    } catch (PDOException $e) {
        echo " Lỗi khi truy vấn: " . $e->getMessage();
    }
}

function minMaxOrderValue($conn) {
    $sql = "SELECT MIN(total_amount) AS min_order, MAX(total_amount) AS max_order FROM orders";

    try {
        $result = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
        echo "<h2> Giá trị đơn hàng nhỏ nhất và lớn nhất:</h2>";
        echo "<p>Nhỏ nhất: " . number_format($result['min_order'], 0, ',', '.') . " VND<br>";
        echo "Lớn nhất: " . number_format($result['max_order'], 0, ',', '.') . " VND</p><hr>";
    } catch (PDOException $e) {
        echo "Lỗi khi truy vấn: " . $e->getMessage();
    }
}

function orderStats($conn) {
    $sql = "SELECT COUNT(*) AS total_orders, SUM(total_amount) AS total_revenue, AVG(total_amount) AS average_value FROM orders";

    try {
        $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
        echo "<h2>Thống kê đơn hàng:</h2>";
        echo "<p>Tổng số đơn hàng: {$row['total_orders']}<br>";
        echo "Tổng tiền đã bán ra: " . number_format($row['total_revenue'], 0, ',', '.') . " VND<br>";
        echo "Trung bình mỗi đơn hàng: " . number_format($row['average_value'], 0, ',', '.') . " VND</p><hr>";
    } catch (PDOException $e) {
        echo "Lỗi khi thống kê: " . $e->getMessage();
    }
}

function laptopProducts($conn) {
    $sql = "SELECT * FROM products WHERE name LIKE 'Laptop%'";

    try {
        $result = $conn->query($sql);
        echo "<h2>Sản phẩm bắt đầu bằng 'Laptop':</h2>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<p>";
            echo "<strong>ID:</strong> {$row['product_id']}<br>";
            echo "<strong>Tên:</strong> {$row['name']}<br>";
            echo "<strong>Giá:</strong> " . number_format($row['price'], 0, ',', '.') . " VND<br>";
            echo "<hr></p>";
        }
    } catch (PDOException $e) {
        echo "Lỗi khi lấy sản phẩm: " . $e->getMessage();
    }
}

// echo "<h2>Danh sách khách hàng Hanoi</h2> ";
// HanoiCustomers($conn);
// echo "<h2>Tìm những đơn hàng có giá trị trên 400.000 đồng và được đặt sau ngày 31/01/2023.</h2> ";
// FilterOrders($conn);

// echo "Lọc ra các khách hàng chưa có địa chỉ email.";

// filterCustomersEmail($conn);

// echo "Xem toàn bộ đơn hàng, sắp xếp theo tổng tiền từ cao xuống thấp.";
// AllOrders($conn);

// echo "Một khách hàng mới tên là Pham Thanh sống tại Can Tho, vừa được thêm vào hệ thống. Hãy thêm dữ liệu này (email để trống).";
// insertNewCustomer($conn);
// echo "Cập nhật địa chỉ email của khách hàng có mã là 2 thành “binh.tran@email.com”";
// updateCustomerEmail($conn);
// echo "Xóa đơn hàng có mã là 103 vì bị nhập nhầm.";
// deleteOrder($conn);

// echo "Lấy danh sách 2 khách hàng đầu tiên trong bảng.";
// firstTwoCustomers($conn);

// echo "Quản lý muốn biết đơn hàng có giá trị lớn nhất và nhỏ nhất hiện tại là bao nhiêu.";
// minMaxOrderValue($conn);

// echo "Tính tổng số lượng đơn hàng, tổng số tiền đã bán ra và trung bình giá trị một đơn hàng.";
// orderStats($conn);

echo "Tìm những sản phẩm có tên bắt đầu bằng chữ “Laptop”.";
laptopProducts($conn);