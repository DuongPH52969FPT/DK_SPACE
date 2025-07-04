import numpy as np
from scipy import stats
from scipy.optimize import minimize

def create_and_save_data():
    """
    Tạo dữ liệu hiệu suất gồm:
    - 4 tuần
    - 5 thành viên
    - Mỗi phần tử lưu [số giờ làm (float), số nhiệm vụ (int)]
    Sau đó lưu vào tệp performance.npy
    """
    data = np.array([
        [[40.5, 5], [38.0, 4], [42.0, 6], [30.5, 3], [42.7, 3]],  # Tuần 1
        [[42.5, 5], [25.0, 3], [23.0, 5], [33.6, 2], [32.5, 5]],  # Tuần 2
        [[45.5, 5], [38.0, 1], [42.0, 6], [30.5, 3], [21.2, 4]],  # Tuần 3
        [[47.5, 5], [31.2, 4], [26.4, 5], [38.0, 4], [43.4, 3]]   # Tuần 4
    ])
    np.save('performance.npy', data)

def basic_analysis():
    """
    Phân tích cơ bản cho từng tuần:
    - Trung bình giờ làm
    - Độ lệch chuẩn giờ làm
    - Tổng nhiệm vụ hoàn thành
    - Thành viên hoàn thành nhiều nhiệm vụ nhất
    """
    data = np.load('performance.npy')  # Đọc dữ liệu từ file
    num_weeks = data.shape[0]          # Số tuần (4)
    
    for week_idx in range(num_weeks):
        week_data = data[week_idx]     # Lấy dữ liệu của 1 tuần (5,2)

        avg_hours = week_data[:, 0].mean()      # Trung bình số giờ
        std_hours = week_data[:, 0].std()       # Độ lệch chuẩn số giờ
        total_tasks = week_data[:, 1].sum()     # Tổng nhiệm vụ
        best_member_idx = week_data[:, 1].argmax()  # Vị trí thành viên tốt nhất
        best_tasks = week_data[best_member_idx, 1]  # Số nhiệm vụ của thành viên tốt nhất

        print(f"Phân tích tuần {week_idx + 1}:")
        print(f"- Trung bình giờ làm: {avg_hours:.2f}")
        print(f"- Độ lệch chuẩn giờ: {std_hours:.2f}")
        print(f"- Tổng nhiệm vụ: {total_tasks}")
        print(f"- Thành viên xuất sắc: Thành viên {best_member_idx + 1} ({best_tasks} nhiệm vụ)\n")

def advanced_analysis():
    """
    Phân tích nâng cao:
    - Hồi quy tuyến tính giữa số giờ làm và số nhiệm vụ
    - Tính hệ số tương quan Pearson
    - Tìm giá trị ngoại lai (giờ làm > hoặc < trung bình ± 2 std)
    """
    data = np.load('performance.npy')
    
    # Trích toàn bộ số giờ và nhiệm vụ (flatten thành 1D array)
    hours = data[:, :, 0].flatten()
    tasks = data[:, :, 1].flatten()

    # Hồi quy tuyến tính
    slope, intercept, r_value, p_value, std_err = stats.linregress(hours, tasks)

    # Tính hệ số tương quan
    corr_coef, _ = stats.pearsonr(hours, tasks)

    # Tìm giá trị ngoại lai (giờ làm vượt quá trung bình ± 2 std)
    mean_hours = hours.mean()
    std_hours = hours.std()
    outliers = hours[(hours < mean_hours - 2 * std_hours) | (hours > mean_hours + 2 * std_hours)]

    print("Hồi quy tuyến tính:")
    print(f"- Độ dốc: {slope:.4f}")
    print(f"- Hệ số tương quan: {corr_coef:.4f}")
    print(f"- Giá trị ngoại lai (giờ làm): {outliers}\n")

def optimize_workload():
    """
    Tối ưu hóa phân bổ giờ làm:
    - Mục tiêu: tối đa tổng nhiệm vụ dựa trên hồi quy tuyến tính
    - Giới hạn: tổng giờ = 200, mỗi người >= 30h
    """
    data = np.load('performance.npy')
    hours = data[:, :, 0].flatten()
    tasks = data[:, :, 1].flatten()

    # Lấy hệ số hồi quy tuyến tính
    slope, intercept, *_ = stats.linregress(hours, tasks)

    # Hàm mục tiêu: âm tổng nhiệm vụ để minimize tìm max
    def objective(x):
        return -np.sum(slope * x + intercept)

    # Ràng buộc: tổng giờ = 200
    cons = ({'type': 'eq', 'fun': lambda x: np.sum(x) - 200})

    # Giới hạn: mỗi người >= 30 giờ
    bounds = [(30, None)] * 5

    # Giá trị ban đầu: mỗi người 40 giờ
    x0 = np.array([40] * 5)

    # Giải bài toán tối ưu
    res = minimize(objective, x0, method='SLSQP', bounds=bounds, constraints=cons)

    if res.success:
        print("Phân bổ giờ làm tuần tới:")
        for i, h in enumerate(res.x):
            print(f"- Thành viên {i + 1}: {h:.2f} giờ")
    else:
        print("Không tìm được phân bổ tối ưu.")

def main():
    """
    Hàm chính:
    - Tạo dữ liệu và lưu file
    - Gọi các hàm phân tích và tối ưu
    """
    create_and_save_data()
    basic_analysis()
    advanced_analysis()
    optimize_workload()

main()
