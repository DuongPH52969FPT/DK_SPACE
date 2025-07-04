# Để tạo database trong MongoDB -> sử dụng use + tên của database
# use banking_system
# Tạo collection customers và transactions trong database trên.
# db.createCollection("customers")
# db.createCollection("transactions")

# Viết lệnh insertOne để thêm một document vào collection customers với dữ liệu mẫu: { customer_id: UUID("550e8400-e29b-41d4-a716-446655440000"), full_name: "Nguyen Van A", email: "nguyen@example.com", created_at: new ISODate("2024-01-01T00:00:00Z") }

# db.customers.insertOne({ customer_id: UUID("550e8400-e29b-41d4-a716-446655440000"), full_name: "Nguyen Van A", email: "nguyen@example.com", created_at: new ISODate("2024-01-01T00:00:00Z") }})

# Viết lệnh insertMany để thêm nhiều document vào collection transactions

# db.transactions.insertMany([
#   { transaction_id: UUID("6ba7b810-9dad-11d1-80b4-00c04fd430c8"), customer_id: UUID("550e8400-e29b-41d4-a716-446655440000"), amount: 1000, type: "DEPOSIT", transaction_date: new ISODate("2024-02-01T10:00:00Z") },
#   { transaction_id: UUID("6ba7b811-9dad-11d1-80b4-00c04fd430c8"), customer_id: UUID("550e8400-e29b-41d4-a716-446655440000"), amount: 500, type: "WITHDRAW", transaction_date: new ISODate("2024-02-02T12:00:00Z") }
# ]
# )

# Viết lệnh find để lấy tất cả document trong customers có full_name chứa "Nguyen" (sử dụng $regex).

# find() có hai đối số  {} {} -> query và projection 
# Điều kiện lọc document (giống WHERE)
# Xác định các trường nào được trả về

# db.customers.find({full_name: {$regex: "Nguyen", $option: "i"}}) 

# $regex: "Nguyen": tìm chuỗi có chứa "Nguyen"

# $options: "i": không phân biệt chữ hoa thường (tìm cả "nguyen", "NGUYEN", ...)

# Viết lệnh findOne để tìm document đầu tiên trong transactions có amount lớn hơn 700.

# db.transactions.findOne({amount: {$gt: 700}})

# Viết truy vấn sử dụng query operators:
# Lấy các giao dịch có amount >= 500 ($gte) và type không phải "WITHDRAW" ($ne).
# Lấy các khách hàng có created_at trước ngày 1/6/2024 ($lt).

# db.transactions.find({amount: {$gte: 500},type: {$ne: "WITHDRAW"}})
# db.customers.find({created_at: {$lt: ISODate("2024-06-01T00:00:00Z")}})

# Viết lệnh updateOne để cập nhật email của khách hàng có customer_id là 550e8400-e29b-41d4-a716-446655440000 thành newemail@example.com.

# db.customers.updateOne({customer_id: UUID("550e8400-e29b-41d4-a716-446655440000")}, {$set:{email:"newemail@example.com"}})

# Viết lệnh updateMany để thêm trường status: "ACTIVE" cho tất cả document trong customers có created_at sau 1/1/2024 ($gt).

# db.customers.updateMany({created_at: {$gt: ISODate("2024-01-01T00:00:00Z")}}, {$set:{status: "ACTIVE"}})

# Viết lệnh deleteOne để xóa giao dịch có transaction_id là 6ba7b811-9dad-11d1-80b4-00c04fd430c8.

# db.transactions.deleteOne({transaction_id: UUID("6ba7b811-9dad-11d1-80b4-00c04fd430c8")})
# db.transactions.find({transaction_id: UUID("6ba7b811-9dad-11d1-80b4-00c04fd430c8")})


# Viết các truy vấn sử dụng các toán tử so sánh:
# $eq: Tìm khách hàng có full_name bằng "Nguyen Van A".
# $gt, $lte: Tìm giao dịch có amount lớn hơn 300 và transaction_date nhỏ hơn hoặc bằng ngày 1/3/2024.
# $ne: Tìm khách hàng không có email là nguyen@example.com.


# db.customers.find({full_name:"Nguyen Van A"})

# db.transactions.find({amount:{$gt: 300},transaction_date: {$lte: ISODate("2024-03-01T00:00:00Z")}})

# db.customers.find({email:{$ne: "nguyen@example.com"}})

