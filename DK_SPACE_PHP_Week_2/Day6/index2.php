<h1>Thêm sách vào giỏ hàng</h1>

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
    <input type="email" name="user_email" value="<?php echo $_POST['user_email'] ?? '' ?>">
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
    $_SESSION['cart'] = [
        'customer_email' => '',
        'products' => [],
        'total_amount' => 0,
        'created_at' => date('Y-m-d H:i:s')
    ];
}

$cart = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $book_name = htmlspecialchars(strip_tags($_POST['book_name'] ?? ''));
        $book_price = (float)($_POST['book_price'] ?? 0);
        $book_quantity = (int)($_POST['book_quantity'] ?? 0);
        $email = $_POST['user_email'] ?? '';
        $phone = $_POST['user_phone'] ?? '';
        $address = htmlspecialchars(strip_tags($_POST['user_address'] ?? ''));

        if (!filter_input(INPUT_POST, 'user_email', FILTER_VALIDATE_EMAIL)) {
            echo "Email không hợp lệ";
        } elseif (!filter_input(INPUT_POST, 'user_phone', FILTER_VALIDATE_REGEXP, [
            "options" => ["regexp" => "/^[0-9]{10}$/"]
        ])) {
            echo "Phone không hợp lệ <br>";
        } elseif (!empty($book_name) && $book_price > 0 && $book_quantity > 0 && !empty($email) && !empty($phone) && !empty($address)) {

            $cart['customer_email'] = $email;
            $found = false;

            foreach ($cart['products'] as &$product) {
                if ($product['title'] === $book_name) {
                    $product['quantity'] += $book_quantity;
                    $product['price'] = $book_price; // Cập nhật giá nếu cần
                    $found = true;
                    break;
                }
            }
            unset($product); // good practice

            if (!$found) {
                $cart['products'][] = [
                    'title' => $book_name,
                    'quantity' => $book_quantity,
                    'price' => $book_price
                ];
            }

            // Tính tổng tiền lại
            $total = 0;
            foreach ($cart['products'] as $product) {
                $total += $product['price'] * $product['quantity'];
            }

            $cart['total_amount'] = $total;

            // Ghi lại vào file và session
            file_put_contents('cart_data.json', json_encode($cart, JSON_PRETTY_PRINT));
            $_SESSION['cart'] = $cart;

            setcookie('cookiename', $email, time() + 604800, '/');
            echo "Sách đã được thêm vào giỏ hàng!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
