<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ứng dụng giao dịch tài chính</title>
</head>

<body>
    <h1>ỨNG DỤNG NHẬP VÀ XỬ LÝ GIAO DỊCH TÀI CHÍNH</h1>
    <form action="" method="POST">

        <div class="box">
            <label for="transaction_name">Tên giao dịch</label>
            <input type="text" name="transaction_name" id="transaction_name" value="">
        </div>

        <div class="box">
            <label for="amount">Số tiền</label>
            <input type="text" name="amount" id="amount">
        </div>

        <div class="box">
            <label>Loại giao dịch</label>
            <div class="radio-group">
                <label><input type="radio" name="type" value="income">Thu</label>
                <label><input type="radio" name="type" value="expense">Chi</label>
            </div>
        </div>

        <div class="box">
            <label for="note">Ghi chú</label>
            <textarea name="note" id="note" rows="4"></textarea>
        </div>

        <div class="box">
            <label for="date">Ngày thực hiện</label>
            <input type="text" name="date" id="date">
        </div>

        <div class="box">
            <input type="submit" value="Gửi giao dịch">
        </div>
    </form>
</body>

</html>

<?php
session_start();

$GLOBALS['expense'] = $GLOBALS['expense'] ?? 0;
$GLOBALS['income'] = $GLOBALS['income'] ?? 0;

$_SESSION['transactions'] = $_SESSION['transactions'] ?? [];

// Sử dụng COOKIE để đếm lần truy cập trang
if (!isset($_COOKIE['visit_count'])) {
    setcookie('visit_count', 1, time() + 3600);
    $visitCount = 1;
} else {
    $visitCount = $_COOKIE['visit_count'] + 1;
    setcookie('visit_count', $visitCount, time() + 3600);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $transaction_name = $_POST['transaction_name'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $type = $_POST['type'] ?? '';
    $note = $_POST['note'] ?? '';
    $date = $_POST['date'] ?? '';

    $errors = [];

    // Validation sử dụng Regular Expression
    $NameRegex = "/^[a-zA-Z0-9\s]+$/";
    $amountRegex = "/^[0-9]+$/";
    $dateRegex = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/';

    if (empty($transaction_name)) {
        $errors[] = "Tên giao dịch không được để trống";
    } elseif (!preg_match($NameRegex, $transaction_name)) {
        $errors[] = "Tên giao dịch không được chứa ký tự đặc biệt";
    }

    if (empty($amount)) {
        $errors[] = "Số tiền không được để trống";
    } elseif (!preg_match($amountRegex, $amount)) {
        $errors[] = "Số tiền phải là số";
    }

    if (empty($type)) {
        $errors[] = "Vui lòng chọn loại giao dịch";
    }

    if (empty($date)) {
        $errors[] = "Ngày không được để trống";
    } elseif (!preg_match($dateRegex, $date)) {
        $errors[] = "Ngày phải nhập đúng định dạng dd/mm/yyyy";
    }

    // Kiểm tra từ khóa nhạy cảm trong ghi chú
    if (!empty($note)) {
        $sensitiveKeywords = ['nợ xấu', 'vay nóng'];
        foreach ($sensitiveKeywords as $keyword) {
            if (stripos($note, $keyword) !== false) {
                $errors[] = "Ghi chú chứa từ khóa nhạy cảm: '$keyword'";
                break;
            }
        }
    }

    // Nếu không có lỗi, xử lý giao dịch
    if (empty($errors)) {
        if ($type === 'income') {
            $_SESSION['income'] = $GLOBALS['income'] += (float)$amount;
        } else {
            $_SESSION['expense'] = $GLOBALS['expense'] += (float)$amount;
        }

        $_SESSION['transactions'][] = [
            'transaction_name' => $transaction_name,
            'amount' => $amount,
            'type' => $type,
            'note' => $note,
            'date' => $date,
        ];
    } else {
        echo "<h2>Errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

function displayTransactions()
{
    if (!empty($_SESSION['transactions'])) {
        echo "<h2>Danh sách giao dịch</h2>";
        echo "<table border='1'>";
        echo "<tr>
                <th>Tên giao dịch</th>
                <th>Số tiền</th>
                <th>Loại</th>
                <th>Ghi chú</th>
                <th>Ngày</th>
              </tr>";
        foreach ($_SESSION['transactions'] as $transaction) {
            echo "<tr>
                    <td>{$transaction['transaction_name']}</td>
                    <td>" . number_format($transaction['amount'], 2) . " VND</td>
                    <td>{$transaction['type']}</td>
                    <td>{$transaction['note']}</td>
                    <td>{$transaction['date']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}

function displaySummary()
{
    $balance = $GLOBALS['income'] - $GLOBALS['expense'];
    echo "<h2>Tổng kết giao dịch</h2>";
    echo "<p><strong>Tổng thu:</strong> " . number_format($GLOBALS['income']) . " USD</p>";
    echo "<p><strong>Tổng chi:</strong> " . number_format($GLOBALS['expense']) . " USD</p>";
    echo "<p><strong>Số dư:</strong> " . number_format($balance) . " USD</p>";
}

displayTransactions();
displaySummary();
echo "<p>Bạn đã truy cập trang này $visitCount lần trong 1 giờ qua.</p>";
?>