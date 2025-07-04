<?php
include 'sql/connect.php';

function getAllCandidates($conn)
{
    $sql = "SELECT *
    FROM Candidates c
    WHERE EXISTS (
        SELECT 1
        FROM Applications a
        JOIN Jobs j ON a.job_id = j.job_id
        WHERE a.candidate_id = c.candidate_id
          AND j.department = 'IT'
    )";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Danh sách ứng viên từng ứng tuyển vào phòng IT:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>";
        echo "<strong>Họ tên:</strong> " . htmlspecialchars($row['full_name']) . "<br>";
        echo "<strong>Email:</strong> " . htmlspecialchars($row['email']) . "<br>";
        echo "<strong>Số điện thoại:</strong> " . ($row['phone']) . "<br>";
        echo "<strong>Số năm kinh nghiệm:</strong> " . htmlspecialchars($row['years_exp']) . "<br>";
        echo "<strong>Mức lương mong muốn:</strong> " . number_format($row['expected_salary'], 0, ',', '.') . " VND<br>";
        echo "<hr></p>";
    }
}

function getJobsWithHighSalary($conn)
{
    $sql = "SELECT *
            FROM Jobs
            WHERE max_salary > ANY (
                SELECT expected_salary FROM Candidates
            )";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Công việc có lương tối đa lớn hơn mức lương mong đợi của ít nhất một ứng viên:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>Vị trí:</strong> {$row['title']} ({$row['department']})<br>";
        echo "<strong>Lương:</strong> " . number_format($row['min_salary']) . " - " . number_format($row['max_salary']) . " VND<br><hr></p>";
    }
}

function getJobsAboveAllExpectations($conn)
{
    $sql = "SELECT *
            FROM Jobs
            WHERE min_salary > ALL (
                SELECT expected_salary FROM Candidates
            )";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Công việc có lương tối thiểu lớn hơn mức lương mong đợi của tất cả ứng viên:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>Vị trí:</strong> {$row['title']} ({$row['department']})<br>";
        echo "<strong>Lương:</strong> " . number_format($row['min_salary']) . " - " . number_format($row['max_salary']) . " VND<br><hr></p>";
    }
}

function insertShortlistedCandidates($conn)
{
    $sql = "INSERT INTO ShortlistedCandidates (candidate_id, job_id, selection_date)
            SELECT candidate_id, job_id, CURRENT_DATE
            FROM Applications
            WHERE status = 'Accepted'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<p><strong>Đã chèn các ứng viên được chọn vào bảng ShortlistedCandidates.</strong></p>";
}


function listCandidatesWithExpLevel($conn)
{
    $sql = "SELECT full_name, years_exp,
                CASE 
                    WHEN years_exp < 1 THEN 'Fresher'
                    WHEN years_exp BETWEEN 1 AND 3 THEN 'Junior'
                    WHEN years_exp BETWEEN 4 AND 6 THEN 'Mid-level'
                    ELSE 'Senior'
                END AS exp_level
            FROM Candidates";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Danh sách ứng viên & mức kinh nghiệm:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>{$row['full_name']}</strong><br>";
        echo "Số năm kinh nghiệm: {$row['years_exp']}<br>";
        echo "Phân loại: <strong>{$row['exp_level']}</strong><br><hr></p>";
    }
}


function listCandidatesWithPhoneHandling($conn)
{
    $sql = "SELECT full_name, email, COALESCE(phone, 'Chưa cung cấp') AS phone
            FROM Candidates";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Danh sách ứng viên (hiển thị số điện thoại nếu có):</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>{$row['full_name']}</strong><br>";
        echo "Email: {$row['email']}<br>";
        echo "Số điện thoại: {$row['phone']}<br><hr></p>";
    }
}


function listJobsWithSalaryRange($conn)
{

    $sql = "SELECT * FROM Jobs
            WHERE max_salary != min_salary AND max_salary >= 1000";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h3>Danh sách công việc có khoảng lương & max_salary >= 1000:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>{$row['title']}</strong><br>";
        echo "Phòng ban: {$row['department']}<br>";
        echo "Lương: " . number_format($row['min_salary']) . " - " . number_format($row['max_salary']) . " VND<br><hr></p>";
    }
}


getAllCandidates($conn);
// getJobsWithHighSalary($conn);
// getJobsAboveAllExpectations($conn);
// insertShortlistedCandidates($conn);
// listCandidatesWithExpLevel($conn);
// listCandidatesWithPhoneHandling($conn);
// listJobsWithSalaryRange($conn);