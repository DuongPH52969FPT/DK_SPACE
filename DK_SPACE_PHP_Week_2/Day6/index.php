<h1>XÂY DỰNG ỨNG DỤNG GIỎ HÀNG ĐƠN GIẢN CHO WEBSITE BÁN SÁCH</h1>

<form action="" method="POST">

    <label for="">Book Name</label>
    <input type="text" name="book_name">
    <br>

    <label for="">Book Price</label>
    <input type="text" name="book_price">
    <br>


    <label for="">Book Quantity</label>
    <input type="number" name="book_quantity">
    <br>


    <label for="">Email</label>
    <input type="email" name="user_email" value="">
    <br>


    <label for="">Phone</label>
    <input type="phone" name="user_phone">
    <br>


    <label for="">Address</label>
    <input type="address" name="user_address">
    <br>


    <button type="submit">Xác nhận đặt hàng</button>

</form>

<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    try {
        $book_name = htmlspecialchars(strip_tags($_POST['book_name'] ?? ''));
        $book_price = $_POST['book_price'] ?? '';
        $book_quantity = $_POST['book_quantity'] ?? '';
        $email = $_POST['user_email'] ?? '';
        $phone = $_POST['user_phone'] ?? '';
        $address = htmlspecialchars(strip_tags($_POST['user_address'] ?? ''));

        $cookiename = $email;

        if (!filter_input(INPUT_POST, 'user_email', FILTER_VALIDATE_EMAIL)) {
            echo "Email không hợp lệ";
        } elseif (!filter_input(
            INPUT_POST,
            'user_phone',
            FILTER_VALIDATE_REGEXP,
            ["options" => ["regexp" => "/^[0-9]{10}$/"]]
        )) {
            echo "Phone không hợp lệ <br>";
        } elseif (!empty($book_name) && !empty($book_price) && !empty($book_quantity) && !empty($email) && !empty($phone) && !empty($address)) {

            if (isset($cart['products'])) {
                $cart['products']['quantity'] += $book_quantity;
            } else {
                $cart = [
                    'customer_email' => $email,
                    'products' => [
                        'title' => $book_name,
                        'quantity' => $book_quantity,
                        'price' => $book_price
                    ],
                    "total_amount" => $book_price * $book_quantity,
                    "created_at" => date('Y-m-d H:i:s')
                ];
            }

            file_put_contents('cart_data.json', json_encode($cart, JSON_PRETTY_PRINT));

            $_SESSION['cart'] = $cart;

            setcookie('cookiename', $email, time() + 604800, '/');

            echo "Sách đã được thêm vào giỏ hàng!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>