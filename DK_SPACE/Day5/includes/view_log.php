<?php
include "header.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? '';
    $logFile = '../logs/log_' . $date . '.txt';

    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        echo "<h2>Log ngày $date</h2>";
        echo "<pre>$logContent</pre>";
    } else {
        echo "<p>Không có log nào vào ngày $date.</p>";
    }
}
?>

<form action="view_log.php" method="POST">
    <label for="date">Chọn ngày (YYYY-MM-DD):</label>
    <input type="date" name="date" id="date" required>
    <button type="submit">Xem Log</button>
</form>