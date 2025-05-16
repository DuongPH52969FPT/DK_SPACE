<?php


echo "<h1> HỆ THỐNG CHẤM CÔNG VÀ TÍNH LƯƠNG NHÂN VIÊN </h1>";

//Nhân viên
$employees = [
    ['id' => 101, 'name' => 'Nguyễn Văn A', 'base_salary' => 5000000],
    ['id' => 102, 'name' => 'Trần Thị B', 'base_salary' => 6000000],
    ['id' => 103, 'name' => 'Lê Văn C', 'base_salary' => 7500000],
];

//Ngày làm việc của nhân viên
$timesheet = [
    101 => ['2025-03-01', '2025-03-02', '2025-03-04', '2025-03-05'],
    102 => ['2025-03-01', '2025-03-03', '2025-03-04'],
    103 => ['2025-03-02', '2025-03-03', '2025-03-04', '2025-03-05', '2025-03-06'],
];


// $newEmployee = [
//     ['id' => 104, 'name' => 'Trần Tùng D', 'base_salary' => 7000000],
// ];

// $employees = array_merge($employees, $newEmployee);

// array_push($timesheet[101], '2025-03-06');

// array_unshift($timesheet[101], '2025-03-06'); 


// print_r($timesheet);

// Xóa ngày công cuối cùng của nhân viên 103
// array_pop($timesheet[103]);

// // Xóa ngày công đầu tiên của nhân viên 101
// array_shift($timesheet[101]);




// Phụ cấp và khấu trừ cơ bản của nhân viên
$adjustments = [
    101 => ['allowance' => 500000, 'deduction' => 200000],
    102 => ['allowance' => 300000, 'deduction' => 100000],
    103 => ['allowance' => 400000, 'deduction' => 150000],
];


// $checkDay = in_array('2025-03-03', $timesheet['102']);

// print_r($checkDay);
// array_key_exists(101, $adjustments);


// Lương = (lương cơ bản / ngày làm việc tiêu chuẩn) × số ngày công thực tế + phụ cấp – khấu trừ
//  (Giả sử 1 tháng có 22 ngày làm việc tiêu chuẩn)

function getWorkDays($timesheet)
{
    return array_map('count', $timesheet);
}

$workDays = getWorkDays($timesheet);


//Lọc ngày công >= 4



function calculateSalary($employees, $workDays, $adjustments)
{
    $standardWorkDays = 22;
    return array_map(function ($employees) use ($workDays, $adjustments, $standardWorkDays) {

        $id = $employees['id'];
        $baseSalary = $employees['base_salary'];
        $days = $workDays[$id] ?? 0;
        $allowance = $adjustments[$id]['allowance'] ?? 0;
        $deduction = $adjustments[$id]['deduction'] ?? 0;

        $salary = ($baseSalary / $standardWorkDays) * $days + $allowance - $deduction;

        return round($salary);
    }, $employees);
}



$salaries = calculateSalary($employees, $workDays, $adjustments);

function getTotalSalary($salaries){
    return array_sum($salaries);
}

$totalSalary = getTotalSalary($salaries);



function generatePayrollTable($employees, $workDays, $adjustments, $salaries)
{
    $report = array_map(function ($employee, $index) use ($workDays, $adjustments, $salaries) {
        $id = $employee['id'];
        $name = $employee['name'];
        $baseSalary = number_format($employee['base_salary']);
        $days = $workDays[$id] ?? 0;
        $allowance = number_format($adjustments[$id]['allowance'] ?? 0);
        $deduction = number_format($adjustments[$id]['deduction'] ?? 0);
        $netSalary = number_format($salaries[$index]); // Sử dụng chỉ số đúng

         // Trả về một mảng kết hợp chứa thông tin đã xử lý của nhân viên
        return compact('id', 'name', 'days', 'baseSalary', 'allowance', 'deduction', 'netSalary');
    }, $employees, array_keys($employees)); // Truyền chỉ số vào

    //Lấy danh sách các khóa (tên cột) từ phần tử đầu tiên
    $keys = array_keys($report[0]); // Lấy các key từ phần tử đầu tiên
    return ['keys' => $keys, 'values' => $report];
}

$report = generatePayrollTable($employees, $workDays, $adjustments, $salaries);

$daytoCheck = '2025-03-20';
function checkEmployeeInfo($employees, $timesheet, $daytoCheck, $adjustments) {
    foreach($employees as $employee) {
        $id = $employee['id'];
        $name = $employee['name'];
    
        $workedOnDay = isset($timesheet[$id]) && in_array($daytoCheck, $timesheet[$id]);
    
        $ifExist = array_key_exists($id, $adjustments);
    
        echo "<strong>$name</strong> có đi làm vào ngày $daytoCheck: " . ($workedOnDay ? 'Có' : 'Không') . "<br>";
        echo "Thông tin phụ cấp của nhân viên $id tồn tại: " . ($ifExist ? 'Có' : 'Không') . "<br><br>";
    
    
    }
}
// Lớc nhân viên có số ngày làm việc >= 4
function filterEmployees($employees, $workDays, $minDays) {
    return array_filter($employees, function ($employee) use ($workDays, $minDays) {
        $id = $employee['id'];
        return isset($workDays[$id]) && $workDays[$id] >= $minDays;
    });
}




function sortEmployee($workDays, $employees)
{
    asort($workDays);
    $minId = array_keys($workDays)[0];
    $maxId = array_keys($workDays)[count($workDays) - 1];

    $minEmployee = array_filter($employees, fn($e) => $e['id'] == $minId);
    $maxEmployee = array_filter($employees, fn($e) => $e['id'] == $maxId);

    return [
        'min' => ['id' => $minId, 'days' => $workDays[$minId], 'employee' => array_values($minEmployee)[0]],
        'max' => ['id' => $maxId, 'days' => $workDays[$maxId], 'employee' => array_values($maxEmployee)[0]],
    ];
}




$sortEmployee = sortEmployee($workDays, $employees);

echo "<h2>BẢNG LƯƠNG NHÂN VIÊN</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr>";
echo "

    <th>Mã NV</th>
    <th>Họ tên</th>
    <th>Ngày công</th>
    <th>Lương cơ bản</th>
    <th>Phụ cấp</th>
    <th>Khẩu trừ</th>
    <th>Lương thực lĩnh</th>
    ";
echo "</tr>";

foreach ($report['values'] as $row) {
    echo "<tr>";
    foreach ($report['keys'] as $key) { // Duyệt qua các key để lấy giá trị
        echo "<td>" . $row[$key] . "</td>"; // Hiển thị từng ô dữ liệu
    }
    echo "</tr>";
}
echo "</table>";

echo "<br>";
echo "<strong> Tổng quỹ lương tháng 03/2025: </strong>" . number_format($totalSalary) . " VND <br>";


$filteredEmployees = filterEmployees($employees, $workDays, 4);



echo "<h2>Danh sách nhân viên đủ điều kiện xét thưởng: >=4 </h2>";
foreach ($filteredEmployees as $employee) {
    echo "Họ tên : ". $employee['name'] . " ( " . $workDays[$employee['id']] ." ngày công )" . "<br>"  ;
}






echo "<h2>Liệt kê nhân viên có ngày công cao nhất và thấp nhất</h2>";
echo "<strong>Mã NV: </strong>" . $sortEmployee['max']['id'] . "<br>";
echo "<strong>Họ tên: </strong>" . $sortEmployee['max']['employee']['name'] . "<br>";
echo "<strong>Ngày công: </strong>" . $sortEmployee['max']['days'] . "<br>";
echo "------------------------------ <br>";
echo "<strong>Mã NV: </strong>" . $sortEmployee['min']['id'] . "<br>";
echo "<strong>Họ tên: </strong>" . $sortEmployee['min']['employee']['name'] . "<br>";
echo "<strong>Ngày công: </strong>" . $sortEmployee['min']['days'] . "<br>";



echo "<h2>Danh sách nhân viên có đi làm vào ngày</h2>";



checkEmployeeInfo($employees, $timesheet, $daytoCheck, $adjustments);

