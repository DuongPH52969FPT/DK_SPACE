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
            <input type="text" name="transaction_name" id="transaction_name">
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
            <input type="date" name="date" id="date">
        </div>

        <div class="box">
            <input type="submit" value="Gửi giao dịch">
        </div>
    </form>
</body>
</html>

<?php
// Sử dụng $_SERVER['REQUEST_METHOD'] để xác định phương thức HTTP (GET hoác POST)
// Nếu mà phương thức là POST => lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $transaction_name = $_POST['transaction_name'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $type = $_POST['type'] ?? '';
    $note = $_POST['note'] ?? '';
    $date = $_POST['date'] ?? '';
    
    $errors = [];

    if (empty($transaction_name)) {
        $errors[] = "Tên giao dịch không được để trống";
    } elseif (!preg_match("/^[a-zA-Z0-9\s]+$/", $transaction_name)) {
        $errors[] = "Tên giao dịch không được chứa ký tự đặc biệt";
    }

    if (!preg_match("/^[0-9]+$/", $amount)) {
        $errors[] = "Số tiền phải là số";
    }

    if ($type === "") {
        $errors[] = "Vui lòng chọn loại giao dịch";
    }

    // Hiển thị lỗi nếu có
    if (!empty($errors)) {
        echo "<h2>Errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    } else {
        displayTransaction($transaction_name, $amount, $type, $note, $date);
    }
}

 // Hiển thị lỗi nếu có
 if (!empty($errors)) {
    echo "<h2>Errors:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
} else {
    // Hiển thị thông tin giao dịch nếu không có lỗi
    displayTransaction($transaction_name, $amount, $type, $note, $date);
}

function displayTransaction($transaction_name, $amount, $type, $note, $date) {
    echo "<h2>Transaction Details</h2>";
    echo "<p>Name: $transaction_name</p>";
    echo "<p>Amount: $amount</p>";
    echo "<p>Type: $type</p>";
    echo "<p>Note: $note</p>";
    echo "<p>Date: $date</p>";

}
?>