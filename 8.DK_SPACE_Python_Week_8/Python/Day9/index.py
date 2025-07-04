import mysql.connector 

import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password=""
)


def setup_database() :

    mycursor = mydb.cursor() 
    #Vai trò của cursor:
    #Gửi câu lệnh SQL đến MySQL server.
    #Lấy kết quả trả về từ server.

    mycursor.execute("CREATE DATABASE IF NOT EXISTS project_progress")
    mycursor.execute("USE project_progress")
    mycursor.execute("CREATE TABLE IF NOT EXISTS members (member_id int PRIMARY KEY  AUTO_INCREMENT, name VARCHAR(100), role VARCHAR(50))")
    mycursor.execute("CREATE TABLE IF NOT EXISTS weekly_progress(progress_id int PRIMARY KEY AUTO_INCREMENT,member_id INT, week_number int, hours_worked float, tasks_completed int,notes TEXT, FOREIGN KEY(member_id) REFERENCES members(member_id))")
    print("CSDL được tạo thành công")

def add_data():
    mycursor = mydb.cursor()

    insert_members = "INSERT INTO members(name,role) VALUES (%s,%s)"
    members_value = [
        ('An', 'Developer'),
        ('Binh', 'Tester'),
        ('Chi', 'Designer'),
        ('Dung', 'Project Manager'),
        ('Huy', 'Developer')
    ]
    insert_weekly_progress = "INSERT INTO weekly_progress (member_id, week_number, hours_worked, tasks_completed, notes) VALUES (%s,%s,%s,%s,%s)"
    weekly_progress_value = [
    (1, 1, 40.0, 5, "Hoàn thành module A"),
    (2, 1, 38.5, 4, "Test case đạt yêu cầu"),
    (3, 1, 35.0, 3, "Thiết kế UI màn hình chính"),
    (4, 1, 42.0, 2, "Quản lý kế hoạch tuần"),
    (5, 1, 40.0, 5, "Viết API module B"),
    (1, 2, 41.0, 6, "Refactor code module A"),
    (2, 2, 39.0, 4, "Viết thêm test case"),
    (3, 2, 36.0, 4, "Thiết kế icon mới"),
    (4, 2, 43.0, 2, "Đánh giá tiến độ"),
    (5, 2, 40.5, 5, "Viết API module C"),
    ]
    mycursor.executemany(insert_members,members_value)
    mycursor.executemany(insert_weekly_progress,weekly_progress_value)

    mydb.commit()

def query_progress(week_number):
    mycursor = mydb.cursor()

    sql = """
    SELECT m.name, w.hours_worked, w.tasks_completed, w.notes
    FROM weekly_progress w
    JOIN members m ON w.member_id = m.member_id
    WHERE w.week_number = %s
    ORDER BY w.tasks_completed DESC
    LIMIT 5
    """

    mycursor.execute(sql, (week_number,))
    results = mycursor.fetchall()

    print(f"Tuần {week_number}:")
    for row in results:
        name, hours, tasks, notes = row
        print(f"- {name}: {hours} giờ, {tasks} nhiệm vụ, Ghi chú: {notes}")

def update_progress(progress_id, new_hours_worked, new_notes):
    mycursor = mydb.cursor()

    sql = """
    UPDATE weekly_progress
    SET hours_worked = %s, notes = %s
    WHERE progress_id = %s
    """

    mycursor.execute(sql, (new_hours_worked, new_notes, progress_id))
    mydb.commit()

    print(f"Đã cập nhật progress_id = {progress_id}: {new_hours_worked} giờ, Ghi chú: {new_notes}")
# update_progress(1, 45.0, "Hoàn thành sớm")

def generate_summary():
    mycursor = mydb.cursor()

    sql = """
    SELECT m.name, SUM(w.hours_worked) AS total_hours, SUM(w.tasks_completed) AS total_tasks
    FROM weekly_progress w
    JOIN members m ON w.member_id = m.member_id
    GROUP BY m.name
    """

    mycursor.execute(sql)
    results = mycursor.fetchall()

    print("Báo cáo tổng kết:")
    for row in results:
        name, total_hours, total_tasks = row
        print(f"- {name}: Tổng {total_hours} giờ, {total_tasks} nhiệm vụ")
def cleanup_database():
    mycursor = mydb.cursor()

    # Kiểm tra xem bảng có tồn tại không
    mycursor.execute("""
        SELECT COUNT(*)
        FROM information_schema.tables
        WHERE table_schema = 'project_progress'
        AND table_name = 'weekly_progress'
    """)
    exists = mycursor.fetchone()[0]

    if exists:
        confirm = input("Bạn có chắc chắn muốn xóa bảng 'weekly_progress'? (y/n): ")
        if confirm.lower() == 'y':
            mycursor.execute("DROP TABLE weekly_progress")
            mydb.commit()
            print("Bảng 'weekly_progress' đã được xóa.")
        else:
            print("Hủy xóa bảng.")
    else:
        print("Bảng 'weekly_progress' không tồn tại.")
def delete_progress(week_number):
    mycursor = mydb.cursor()

    sql = "DELETE FROM weekly_progress WHERE week_number = %s"
    mycursor.execute(sql, (week_number,))
    mydb.commit()

    print(f"Đã xóa dữ liệu của tuần {week_number}.")

def main():
    setup_database()
    add_data()

    # Truy vấn tiến độ tuần 1
    query_progress(1)

    # Cập nhật 1 bản ghi: progress_id = 1
    update_progress(1, 45.0, "Hoàn thành sớm")

    # Truy vấn lại để xem kết quả sau update
    query_progress(1)

    # Xóa dữ liệu của tuần 2
    # delete_progress(2)

    # Tạo báo cáo tổng kết
    generate_summary()

    # Hỏi người dùng có dọn dẹp database không
    # cleanup_database()
main()