booklist = [
    {"name": "Python Basics", "price": 99999, "stock": 20, "sold": 5},
    {"name": "Flask for Web", "price": 120500, "stock": 15, "sold": 3},
    {"name": "Data Science 101", "price": 199000, "stock": 0, "sold": 12},
    {"name": "Machine Learning", "price": 250000, "stock": 8, "sold": 18},
    {"name": "Tiny Tips", "price": 45000, "stock": 12, "sold": 15}
]

def calculate_bill(book_name, quantity, customer_type):
    if not isinstance(quantity, int) or quantity <= 0:
        return "Số lượng mua phải là số nguyên dương."
    for book in booklist:
        if book["name"] == book_name:
            if book["stock"] == 0:
                return f"Sách '{book_name}' hiện đã hết hàng."
            if quantity > book["stock"]:
                return f"Không đủ hàng. Chỉ còn {book['stock']} cuốn."
            price = float(book["price"])
            total = price * quantity
            if customer_type.upper() == "VIP":
                total *= 0.9
            return round(total, 2)
    return f"Không tìm thấy sách có tên '{book_name}'."

def check_stock(book_name, quantity):
    for book in booklist:
        if book["name"] == book_name:
            if book["stock"] >= quantity:
                in_stock = True
                message = "Còn hàng"
            else:
                in_stock = False
                message = "Hết hàng hoặc không đủ"
            price = book["price"]
            match price:
                case p if p < 50000:
                    category = "Sách giá rẻ"
                case p if 50000 <= p <= 100000:
                    category = "Sách trung bình"
                case p if p > 100000:
                    category = "Sách cao cấp"
                case _:
                    category = "Không rõ phân loại"
            return (in_stock, message, category)
    return (False, "Không tìm thấy sách.", None)

# Lambda tạo mã giảm giá
generate_coupon = lambda name, ctype: name.upper() + ("_VIP" if ctype.upper() == "VIP" else "_REG")

# Hàm chính
def main():
    print("[TÍNH TOÁN HÓA ĐƠN]")
    result1 = calculate_bill("Machine Learning", 2, "VIP")
    print("Kết quả:", result1)

    print("\n[KIỂM TRA TỒN KHO]")
    result2 = check_stock("Tiny Tips", 5)
    print("Kết quả:", result2)

    print("\n[MÃ GIẢM GIÁ]")
    print(generate_coupon("Alice", "VIP"))
    print(generate_coupon("Bob", "regular"))

    print("\n[SÁCH BÁN CHẠY (>10)]")
    for book in booklist:
        if book["sold"] > 10:
            print("-", book["name"])

    print("\n[SÁCH BÁN CHẠY NHẤT]")
    i = 1
    best = booklist[0]
    while i < len(booklist):
        if booklist[i]["sold"] > best["sold"]:
            best = booklist[i]
        i += 1
    print(f"{best['name']} (Đã bán: {best['sold']})")


main()
