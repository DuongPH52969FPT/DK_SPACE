import numpy as np

# === DỮ LIỆU MẪU BAN ĐẦU ===
events = [
    {"id": "EV001", "name": "Hội chợ sách", "ticket_price": 100.00, "tickets_left": 23},
    {"id": "EV002", "name": "Triển lãm tranh", "ticket_price": 500.00, "tickets_left": 24},
    {"id": "EV003", "name": "Workshop gốm sứ", "ticket_price": 400.00, "tickets_left": 65},
    {"id": "EV004", "name": "Lễ hội ẩm thực", "ticket_price": 300.00, "tickets_left": 34},
    {"id": "EV005", "name": "Đêm nhạc dân gian", "ticket_price": 200.00, "tickets_left": 36}
]

sponsors = {
    "SP001": ("Công ty A", 5000000.0),
    "SP002": ("Tập đoàn Văn hóa Việt", 3000000.0),
    "SP003": ("Công ty Du lịch Bến Thành", 2000000.0)
}

sold_event_ids = set()
ticket_history = []


def manage_events(events):
    print("\n--- Quản lý sự kiện ---")
    try:
        new_event = {
            "id": input("Nhập mã sự kiện mới: ").strip(),
            "name": input("Nhập tên sự kiện: ").strip(),
            "ticket_price": float(input("Nhập giá vé: ")),
            "tickets_left": int(input("Nhập số vé còn lại: "))
        }
        events.append(new_event)
        print("Đã thêm sự kiện mới.")

        update_id = input("Nhập mã sự kiện cần cập nhật vé: ").strip()
        found = False
        for e in events:
            if e["id"] == update_id:
                new_qty = int(input("Nhập số vé còn lại mới: "))
                if new_qty < 0:
                    print("Không được nhập số âm.")
                else:
                    e["tickets_left"] = new_qty
                    print("Đã cập nhật.")
                found = True
                break
        if not found:
            print("Không tìm thấy sự kiện.")

        print("\nDanh sách sự kiện:")
        for e in events:
            print(f"- {e['id']} | {e['name']} | Giá vé: {e['ticket_price']} | Còn lại: {e['tickets_left']} vé")

        prices = np.array([e["ticket_price"] for e in events])
        avg_price = np.mean(prices)
        print(f"Giá vé trung bình: {avg_price:.2f} VNĐ")

    except ValueError:
        print("Lỗi dữ liệu đầu vào.")


def manage_sponsors(sponsors):
    print("\n--- Quản lý nhà tài trợ ---")
    sponsor_id = input("Nhập mã nhà tài trợ: ").strip()
    name = input("Nhập tên nhà tài trợ: ").strip()
    amount = float(input("Nhập số tiền tài trợ: "))
    sponsors[sponsor_id] = (name, amount)
    print("Đã thêm nhà tài trợ.")

    lookup = input("Nhập mã nhà tài trợ cần xem: ").strip()
    if lookup in sponsors:
        print(f"Thông tin: {lookup} | {sponsors[lookup][0]} | {sponsors[lookup][1]:,.0f} VNĐ")
    else:
        print("Không tìm thấy.")

    print("\nDanh sách nhà tài trợ:")
    for sid, (name, amount) in sponsors.items():
        print(f"- {sid} | {name} | {amount:,.0f} VNĐ")


def process_tickets(events, sold_event_ids, ticket_history):
    print("\n--- Xử lý vé bán ---")
    for i in range(2):
        event_id = input(f"Nhập mã sự kiện bán vé {i+1}: ").strip()
        ticket_id = input("Nhập mã vé (TICKET_XXX): ").strip()
        qty = int(input("Nhập số lượng vé bán: "))

        ticket_history.append({
            "event_id": event_id,
            "ticket_id": ticket_id,
            "quantity": qty
        })
        if qty > 0:
            sold_event_ids.add(event_id)

    check_id = input("Nhập mã sự kiện cần kiểm tra vé đã bán: ").strip()
    if check_id in sold_event_ids:
        print("Đã có vé bán hôm nay.")
    else:
        print("Chưa có vé bán.")

    print("\nDanh sách giao dịch bán vé:")
    for t in ticket_history:
        print(f"- {t['ticket_id']} | {t['event_id']} | {t['quantity']} vé")

    before = len(ticket_history)
    ticket_history[:] = [t for t in ticket_history if t["quantity"] > 0]
    removed = before - len(ticket_history)
    if removed:
        print(f"Đã xóa {removed} giao dịch có 0 vé.")


def generate_report(events, ticket_history, sold_event_ids):
    print("\n--- Báo cáo thống kê ---")
    low_tickets = [e["name"] for e in events if e["tickets_left"] < 20]
    print(f"Sự kiện sắp hết vé: {low_tickets if low_tickets else 'Không có'}")

    total_value = sum(e["ticket_price"] * e["tickets_left"] for e in events)
    print(f"Tổng giá trị vé còn lại: {total_value:,.0f} VNĐ")

    sold_ids = {t["event_id"] for t in ticket_history}
    print(f"Sự kiện đã bán vé: {sold_ids if sold_ids else 'Không có'}")


def main():
    print("Chào mừng đến với hệ thống quản lý sự kiện văn hóa")

    manage_events(events)
    manage_sponsors(sponsors)
    process_tickets(events, sold_event_ids, ticket_history)
    generate_report(events, ticket_history, sold_event_ids)


main()
