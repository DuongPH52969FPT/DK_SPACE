//Sử dụng explain và cải tiện


EXPLAIN SELECT * 
FROM Orders 
JOIN OrderItems ON Orders.order_id = OrderItems.order_id
WHERE status = 'Shipped'
ORDER BY order_date DESC;

//Tạo chỉ mục phù hợp để tăng tốc truy vấn theo status, order_date.

CREATE INDEX idx_orders_status_orderdate 
ON Orders(status, order_date DESC);

//Tạo composite index cho bảng OrderItems theo order_id, product_id để hỗ trợ JOIN hiệu quả.

CREATE INDEX idx_orderitems_orderid_productid 
ON OrderItems(order_id, product_id);

//Sửa * để chỉ lấy côt cần thiết BY

SELECT Orders.order_id, Orders.order_date, OrderItems.product_id, OrderItems.quantity
FROM Orders 
JOIN OrderItems ON Orders.order_id = OrderItems.order_id
WHERE Orders.status = 'Shipped'
ORDER BY Orders.order_date DESC;

//So sánh hiệu suất JOIN vs Subquery 

SELECT P.product_id, P.name, C.name AS category_name
FROM Products P
JOIN Categories C ON P.category_id = C.category_id;

SELECT product_id, name,
    (SELECT name FROM Categories C WHERE C.category_id = P.category_id) AS category_name
FROM Products P;

JOIN ->  Khả năng mở rộng  cao hơn  - Dễ đọc

Subquery ->  Thường chậm hơn khi dữ liệu lớn - Dễ rối khi nhiều cấp

//truy vấn để lấy 10 sản phẩm mới nhất trong danh mục “Electronics”, có stock_quantity > 0.

//SELECT P.product_id, P.name, P.price, P.stock_quantity
FROM Products P
JOIN Categories C ON P.category_id = C.category_id
WHERE C.name = 'Electronics'
  AND P.stock_quantity > 0
ORDER BY P.created_at DESC
LIMIT 10;

//Tạo Covering Index cho truy vấn thường xuyên 

SELECT product_id, name, price 
FROM Products 
WHERE category_id = 3 
ORDER BY price ASC 
LIMIT 20;

CREATE INDEX idx_products_covering 
ON Products(category_id, price, product_id, name);


//Top 5 sản phẩm bán chạy nhất trong 30 ngày gần nhất:

//SELECT P.product_id, P.name, SUM(OI.quantity) AS total_sold
FROM OrderItems OI
JOIN Orders O ON OI.order_id = O.order_id
JOIN Products P ON OI.product_id = P.product_id
WHERE O.order_date >= CURDATE() - INTERVAL 30 DAY
GROUP BY P.product_id, P.name
ORDER BY total_sold DESC
LIMIT 5;