import pendulum
import re
import json

# Danh sách khóa học
courses = {
    "KH001": 1000000,
    "KH002": 2000000,
    "KH003": 1500000
}

def validate_input(email, course_id):
    emailReg = r"^[\w\.-]+@[\w\.-]+\.\w+$"
    courseReg = r"^KH\d{3}$"
    if not re.fullmatch(emailReg, email):
        raise ValueError("Email không hợp lệ!")
    if not re.fullmatch(courseReg, course_id):
        raise ValueError("Mã khóa học không hợp lệ! (Ví dụ: KH001)")
    return True

def calculate_cost(price, quantity, discount_code):
    total = price * quantity
    if discount_code == "SUMMER25":
        total *= 0.75
    elif discount_code == "EARLYBIRD":
        total *= 0.85
    return round(total, 2)

def save_registration(name, email, course_id, date, cost):
    registration = {"name": name, "email": email, "course_id": course_id, "date": date, "cost": cost}
    try:
        with open("registrations.json", "r", encoding="utf-8") as f:
            data = json.load(f)
    except (FileNotFoundError, json.JSONDecodeError):
        data = []
    data.append(registration)
    with open("registrations.json", "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=4)

def load_registrations():
    try:
        with open("registrations.json", "r", encoding="utf-8") as f:
            data = json.load(f)
    except (FileNotFoundError, json.JSONDecodeError):
        print("Không có dữ liệu đăng ký!")
        return
    print("\nDanh sách đăng ký:")
    for reg in data:
        print(
            f"- {reg['name']} đã đăng ký {reg['course_id']} "
            f"vào ngày {reg['date']} với chi phí \n {reg['cost']:,} VNĐ"
        )

def main():
    print("=== Chương trình đăng ký khóa học ===")

    # Nhập và validate thông tin
    while True:
        try:
            name = input("Vui lòng nhập tên (ít nhất 4 ký tự): ")
            if len(name) < 4:
                raise ValueError("Tên quá ngắn!")
            email = input("Vui lòng nhập email: ")
            course_id = input("Vui lòng nhập mã khóa học (VD: KH001): ").upper().strip()
            validate_input(email, course_id)
            break
        except ValueError as e:
            print(f"Lỗi: {e}")

    now = pendulum.now().strftime("%d/%m/%Y")
    print(f"Chúc mừng {name} đã đăng ký khóa học {course_id} vào ngày {now}!")

    # Nhập số lượng và giảm giá
    while True:
        try:
            quantity = int(input("Nhập số lượng khóa học bạn muốn đăng ký: "))
            if quantity <= 0:
                raise ValueError("Số lượng phải > 0!")
            break
        except ValueError as e:
            print(f"Lỗi: {e}")

    discount_code = input("Nhập mã ưu đãi (nếu có): ").upper().strip()
    cost = calculate_cost(courses[course_id], quantity, discount_code)

    print(f"Tổng chi phí cho {quantity} khóa học là: {cost:,} VNĐ")

    # Lưu file
    save_registration(name, email, course_id, now, cost)

    # Đọc và in danh sách đăng ký
    load_registrations()

if __name__ == "__main__":
    main()
