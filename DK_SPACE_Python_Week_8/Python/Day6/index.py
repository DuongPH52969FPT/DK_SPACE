import os 
def create_weekly_log():
    try:
        # Nhập dữ liệu từ người dùng
        weeks = int(input("Nhập số tuần: "))
        hours = float(input("Nhập số giờ làm trong ngày: "))
        works_done = int(input("Nhập số nhiệm vụ hoàn thành: "))
        description = input("Nhập ghi chú: ")

        # Ghi dữ liệu vào file
        with open(f"week_{weeks}.txt", 'w', encoding='utf-8') as file_log:
            file_log.write(f"Tuần: {weeks}\nSố giờ làm việc: {hours}\nNhiệm vụ hoàn thành: {works_done}\nGhi chú: {description}")
        print("Log tạo thành công\n")

    except ValueError:
        # Bắt lỗi nếu người dùng nhập sai kiểu dữ liệu
        print("Dữ liệu nhập không hợp lệ. Vui lòng thử lại.")

def read_weekly_log():
    try:
        weeks = int(input("Vui lòng nhập số tuần cần đọc: "))
        file_name = f"week_{weeks}.txt"
        if not os.path.exists(file_name):
            print(f"Không tìm thấy nhật ký tuần {weeks}")
            return

        # Đọc và in nội dung file
        with open(file_name, 'r', encoding='utf-8') as file_read:
            content = file_read.read()
            print(f"\n{content}\n")

    except ValueError:
        print("Vui lòng nhập số tuần là số nguyên hợp lệ.")

        
def update_weekly_log():
    try:
        weeks = int(input("Vui lòng nhập số tuần cần cập nhật: "))
        hours = float(input("Nhập số giờ làm việc mới: "))
        works_done = int(input("Nhập số nhiệm vụ hoàn thành mới: "))
        description = input("Nhập ghi chú mới: ")

        # Ghi đè file
        with open(f"week_{weeks}.txt", 'w', encoding='utf-8') as file_update:
            file_update.write(f"Tuần: {weeks}\nSố giờ làm việc: {hours}\nNhiệm vụ hoàn thành: {works_done}\nGhi chú: {description}")
        print(f"Nhật ký tuần {weeks} đã được cập nhật.")

    except ValueError:
        print("Dữ liệu nhập không hợp lệ. Vui lòng thử lại.")


def delete_weekly_log():
    try:
        weeks = int(input("Vui lòng nhập số tuần cần xóa: "))
        os.remove(f"week_{weeks}.txt")
        print(f"Đã xóa nhật ký tuần {weeks}")

    except ValueError:
        print("Vui lòng nhập số tuần là số nguyên hợp lệ.")
    except FileNotFoundError:
        print(f"Không tìm thấy nhật ký tuần {weeks}")


def generate_summary():
    # Tổng hợp dữ liệu từ tất cả file tuần
    total_weeks = 0
    total_hours = 0
    total_works = 0

    for file_name in os.listdir("."):
        if file_name.startswith("week_") and file_name.endswith(".txt"):
            with open(file_name, 'r', encoding='utf-8') as file:
                for line in file:
                    if line.startswith("Số giờ làm việc:"):
                        try:
                            total_hours += float(line.split(":")[1].strip())
                        except ValueError:
                            print(f"Lỗi dữ liệu trong file {file_name}")
                    if line.startswith("Nhiệm vụ hoàn thành:"):
                        try:
                            total_works += int(line.split(":")[1].strip())
                        except ValueError:
                            print(f"Lỗi dữ liệu trong file {file_name}")
            total_weeks += 1

    # In báo cáo
    print(f"\nBáo cáo tổng kết:")
    print(f"Tổng số tuần: {total_weeks}")
    print(f"Tổng số giờ làm việc: {total_hours:.2f}")
    print(f"Tổng nhiệm vụ hoàn thành: {total_works}\n")



def main() :
    while True :
        print("Quản lý nhật ký tuần làm việc \n" \
        "1.Tạo nhật ký tuần mới\n" \
        "2.Đọc nhật ký tuần. \n" \
        "3.Cập nhật nhật ký tuần. \n" \
        "4.Xóa nhật ký tuần. \n" \
        "5.Tạo báo cáo tổng kết. \n" \
        "6.Thoát.")
        try :
            user_input = int(input("Vui lòng chọn: "))
            if user_input == 1 :
                create_weekly_log()

            elif user_input == 2:
                read_weekly_log()

            elif user_input == 3:
                update_weekly_log()

            elif user_input == 4:
                delete_weekly_log()
            elif user_input == 5:
                generate_summary()
            
            elif user_input == 6:
                print("Đã thoát thành công")
                break
            else:
                print("Vui lòng chọn từ 1 đến 6")
        except ValueError:
            print("Vui lòng nhập chọn từ 1 - 6")
main()
