import pandas as pd
import matplotlib.pyplot as plt

# Dữ liệu ban đầu
data = {
    "Tên": ["An", "Bình", "An"],
    "Tuần": [1, 1, 2],
    "Bài tập": [5, 4, 6],
    "Điểm": [8.5, 7.0, 9.0],
}

def analyze_weekly_progress():
    """Phân tích dữ liệu từng tuần: bài tập và điểm trung bình, học viên xuất sắc"""
    try:
        dataFrame = pd.read_csv("Python/Day7/progress.csv")
    except FileNotFoundError:
        print("⚠ Tệp dữ liệu không tồn tại.")
        return
    if dataFrame.empty:
        print("⚠ Dữ liệu trống.")
        return

    avg_work_per_week = dataFrame.groupby("Tuần")["Bài tập"].mean()
    avg_score_per_week = dataFrame.groupby("Tuần")["Điểm"].mean()

    for week_number, week_data in dataFrame.groupby("Tuần"):
        avg_works = avg_work_per_week.loc[week_number]
        avg_score = avg_score_per_week.loc[week_number]

        top_student_row = week_data.loc[week_data["Điểm"].idxmax()]
        top_student_name = top_student_row["Tên"]
        top_student_score = top_student_row["Điểm"]

        print(f"Phân tích tuần {week_number}:")
        print(f"- Bài tập trung bình: {avg_works:.2f}")
        print(f"- Điểm trung bình: {avg_score:.2f}")
        print(f"- Học viên xuất sắc: {top_student_name} ({top_student_score})\n")

def visualize_progress():
    """Tạo biểu đồ đường và cột, lưu thành file"""
    try:
        dataFrame = pd.read_csv("Python/Day7/progress.csv")
    except FileNotFoundError:
        print("⚠ Tệp dữ liệu không tồn tại.")
        return
    if dataFrame.empty:
        print("⚠ Dữ liệu trống.")
        return

    # Biểu đồ đường: xu hướng điểm trung bình từng học viên
    student_avg = dataFrame.groupby(["Tên", "Tuần"])["Điểm"].mean().reset_index()
    plt.figure(figsize=(8,6))
    for student in student_avg["Tên"].unique():
        student_data = student_avg[student_avg["Tên"] == student]
        plt.plot(student_data["Tuần"], student_data["Điểm"], marker='o', label=student)
    plt.title("Xu hướng điểm trung bình qua các tuần")
    plt.xlabel("Tuần")
    plt.ylabel("Điểm trung bình")
    plt.legend()
    plt.grid(True)
    plt.savefig("Python/Day7/img/trend.png")
    plt.close()

    # Biểu đồ cột: số bài tập trung bình theo tuần
    work_avg = dataFrame.groupby("Tuần")["Bài tập"].mean().reset_index()
    plt.figure(figsize=(8,6))
    plt.bar(work_avg["Tuần"], work_avg["Bài tập"], color='skyblue')
    plt.title("Số bài tập hoàn thành trung bình theo từng tuần")
    plt.xlabel("Tuần")
    plt.ylabel("Số bài tập trung bình")
    plt.xticks(work_avg["Tuần"])
    plt.grid(axis='y')
    plt.savefig("Python/Day7/img/comparison.png")
    plt.close()

def generate_weekly_report():
    """Tạo báo cáo tổng kết và biểu đồ tròn"""
    try:
        dataFrame = pd.read_csv("Python/Day7/progress.csv")
    except FileNotFoundError:
        print("⚠ Tệp dữ liệu không tồn tại.")
        return
    if dataFrame.empty:
        print("⚠ Dữ liệu trống.")
        return

    summary = dataFrame.groupby("Tên").agg(
        total_work=pd.NamedAgg(column="Bài tập", aggfunc="sum"),
        avg_score=pd.NamedAgg(column="Điểm", aggfunc="mean")
    ).reset_index()

    student_weeks = dataFrame.pivot_table(index="Tên", columns="Tuần", values="Điểm", aggfunc="mean")

    week_numbers = sorted(dataFrame["Tuần"].unique())
    first_week = week_numbers[0]
    last_week = week_numbers[-1]

    student_weeks["improvement"] = student_weeks[last_week] - student_weeks[first_week]
    most_improved = student_weeks["improvement"].idxmax()
    improvement_value = student_weeks.loc[most_improved, "improvement"]

    plt.figure(figsize=(6,6))
    plt.pie(summary["total_work"], labels=summary["Tên"], autopct='%1.1f%%', startangle=90)
    plt.title("Tỷ lệ đóng góp bài tập của từng học viên")
    plt.savefig("Python/Day7/img/contribution.png")
    plt.close()

    with open("Python/Day7/report.txt", "w", encoding="utf-8") as f:
        f.write("Báo cáo tổng kết:\n")
        for _, row in summary.iterrows():
            f.write(f"- Tổng bài tập của {row['Tên']}: {row['total_work']}\n")
            f.write(f"- Điểm trung bình của {row['Tên']}: {row['avg_score']:.2f}\n")
        f.write(f"- Học viên tiến bộ nhất: {most_improved} (tăng {improvement_value:.2f} điểm)\n")

def main():
    """Tích hợp toàn bộ chương trình"""
    # Tạo DataFrame ban đầu và lưu vào file CSV
    df = pd.DataFrame(data)
    df.to_csv("Python/Day7/progress.csv", index=False, encoding="utf-8-sig")
    print("✅ Đã lưu dữ liệu vào progress.csv")

    # Phân tích dữ liệu
    analyze_weekly_progress()

    # Tạo biểu đồ đường và cột
    visualize_progress()
    print("✅ Đã tạo biểu đồ trend.png và comparison.png")

    # Tạo báo cáo tổng kết và biểu đồ tròn
    generate_weekly_report()
    print("✅ Đã tạo report.txt và contribution.png")

# Gọi chương trình
main()
