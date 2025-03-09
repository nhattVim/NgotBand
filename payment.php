<?php

require 'assets/PHPMailer/src/Exception.php';
require 'assets/PHPMailer/src/PHPMailer.php';
require 'assets/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_bill = uniqid();
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $province = $conn->real_escape_string($_POST['province']);
    $district = $conn->real_escape_string($_POST['district']);
    $ward = $conn->real_escape_string($_POST['ward']);

    $sql_cart = "SELECT id_product, name_product, price, sl_order AS sl_add FROM cart_product";
    $result_cart = $conn->query($sql_cart);

    if ($result_cart->num_rows > 0) {
        $delivery_option = $_POST['delivery_option'];
        if ($delivery_option == 'home') {
            $payment = "Giao tận nơi";
            $ship = 35;
        } else {
            $payment = "Nhận tại cửa hàng";
            $address = null;
            $province = null;
            $district = null;
            $ward = null;
            $ship = 0;
        }
        $created = date("Y-m-d");
        $username = "chưa làm";

        while ($row_cart = $result_cart->fetch_assoc()) {
            $id_product = $row_cart['id_product'];
            $name_product = $row_cart['name_product'];
            $price = $row_cart['price'];
            $sl_add = $row_cart['sl_add'];
            $amount = $price * $sl_add + $ship;
            $total += $amount;

            $sql = "INSERT INTO information (id_bill, name, phone, mail, address, province, district, ward, id_product, name_product, price, sl_add, ship, amount, payment, created, username)
            VALUES ('$id_bill', '$name', '$phone', '$email', '$address', '$province', '$district', '$ward', '$id_product', '$name_product', '$price', '$sl_add', '$ship', '$amount', '$payment', '$created', '$username')";

            if ($conn->query($sql) === FALSE) {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }
        }

        $sql1 = "INSERT INTO bill (id_bill, name, phone, created, total)
        VALUES ('$id_bill', '$name', '$phone', '$created', $total)";

        if ($conn->query($sql1) === TRUE) {
            $sql4 = "DELETE FROM cart_product";
            $conn->query($sql4);

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lamhuynhgaming@gmail.com';
            $mail->Password = 'jwcg rcrp msry mppw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('lamhuynhgaming@gmail.com', 'Ngọt - Shop');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Đơn hàng ' . $id_bill . ' đã được tiếp nhận';
            $mail->Body = '<strong>Cảm ơn ' . $name . ' đã mua hàng.</strong> <br> <br>

            Hóa đơn của <strong>' . $name . '</strong> bao gồm: <br> ';

            $sql_products = "SELECT name_product, price, sl_add FROM information WHERE id_bill = '$id_bill'";
            $result_products = $conn->query($sql_products);

            if ($result_products->num_rows > 0) {
                while ($row_product = $result_products->fetch_assoc()) {
                    $name_product = $row_product['name_product'];
                    $price = $row_product['price'];
                    $sl_add = $row_product['sl_add'];

                    $mail->Body .= "$name_product x $sl_add = $price.000VNĐ<br>";
                }
            }

            if (empty($address) && empty($province) && empty($district) && empty($ward)) {
                $mail->Body .= '<br><strong>Tổng cộng:</strong> ' . $total . '.000VNĐ (Đã gồm ship) <br> <br>

            <strong>Với thông tin giao hàng:</strong> <br>
            Họ tên: ' . $name . '<br>
            Số điện thoại: ' . $phone . '<br>
            Mail: ' . $email . '<br>
            Địa chỉ: Nhận tại cửa hàng (170 An Dương Vương, Nguyễn Văn Cừ, Quy Nhơn, Bình Định) <br> <br>

            <strong>Hãy tiến hành thanh toán như sau:</strong> <br>
            Nội dung: ' . $name . ' + ' . $phone . ' + ' . $id_bill. '<br>
            Hoặc bạn có thể tới tại cửa hàng để thanh toán. <br> <br>
            
            <strong>Lưu ý: Nếu trong 5 ngày kể từ ngày đặt hàng không nhận được phản hồi gì từ bên khách hàng, đơn hàng sẽ bị hủy. Cảm ơn quý khách <3</strong>';
            } else {
                $mail->Body .= '<br><strong>Tổng cộng:</strong> ' . $total . '.000VNĐ (Đã gồm ship) <br> <br>

            <strong>Với thông tin giao hàng:</strong> <br>
            Họ tên: ' . $name . '<br>
            Số điện thoại: ' . $phone . '<br>
            Mail: ' . $email . '<br>
            Địa chỉ: ' . $address . '<br>
            Tỉnh/Thành phố: ' . $province . '<br>
            Quận/Huyện: ' . $district . '<br>
            Phường/Xã: ' . $ward . '<br> <br>

            <strong>Hãy tiến hành thanh toán như sau:</strong> <br>
            Nội dung: ' . $name . ' + ' . $phone . ' + ' . $id_bill . ' <br> <br>
            <strong>Lưu ý: Nếu trong 5 ngày kể từ ngày đặt hàng không nhận được phản hồi gì từ bên khách hàng, đơn hàng sẽ bị hủy. Cảm ơn quý khách <3</strong>';
            }

            $mail->addAttachment('./assets/img/succesful/qr_code.png');

            $mail->send();


            header("Location: succesful.php");
            exit();
        }
    }
}

$sql3 = "SELECT * FROM cart_product";
$result = $conn->query($sql3);

$sql2 = "SELECT COALESCE(SUM(sl_order), 0) AS total_price FROM cart_product";
$result2 = $conn->query($sql2);
$row = $result2->fetch_assoc();
$totalPrice = $row['total_price'];

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="./assets/css/payment.css">
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png">
</head>

<body>
    <header class="header">
        <div class="header__logo">
            <a href="index.html"><img src="./assets/img/logo/logo.png" alt="" class="header__logo--photograp"></a>
        </div>
    </header>


    <div class="checkout-container">
        <div class="left-column">
            <h1>Thông tin giao hàng</h1>
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            <form id="checkout-form" action="#" method="post">
                <label for="name">Họ và tên:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" required>

                <div class="delivery-option">
                    <input type="radio" id="delivery" name="delivery_option" value="home" checked>
                    <label for="delivery">Giao tận nơi</label>
                    <input type="radio" id="store-pickup" name="delivery_option" value="store">
                    <label for="store-pickup">Nhận tại cửa hàng</label>
                </div>

                <div class="address-fields">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" id="address" name="address">

                    <div>
                        <select class="form-select form-select-sm mb-3" id="province" name="province" aria-label=".form-select-sm">
                            <option value="" selected>Chọn tỉnh thành</option>
                        </select>

                        <select class="form-select form-select-sm mb-3" id="district" name="district" aria-label=".form-select-sm">
                            <option value="" selected>Chọn quận huyện</option>
                        </select>

                        <select class="form-select form-select-sm" id="ward" name="ward" aria-label=".form-select-sm">
                            <option value="" selected>Chọn phường xã</option>
                        </select>
                    </div>
                </div>

                <div class="store-address" style="display: none;">
                    <h3>Địa chỉ cửa hàng:</h3>
                    <p>170 An Dương Vương, Nguyễn Văn Cừ, Quy Nhơn, Bình Định</p>
                </div>

                <button type="submit"><span>Tiếp tục đến phương thức thanh toán</span></button>
            </form>
        </div>
        <div class="right-column">
            <h2>Giỏ hàng</h2>
            <?php
            $total = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $itemTotal = $row["price"] * $row["sl_order"];
                    $total += $itemTotal;
                    echo '<div class="cart-item">';
                    echo '<img src="./assets/img/shop/' . $row["img_product"] . '" alt="' . $row["name_product"] . '">';
                    echo '<p>' . $row["name_product"] . '</p>';
                    echo '<span>' . number_format($itemTotal, 0, ',', '.') . '.000VND</span>';
                    echo '</div>';
                }
            } else {
                echo '<p>Giỏ hàng trống</p>';
            }
            ?>
            <label for="promo-code">Mã giảm giá:</label>
            <input type="text" id="promo-code" name="promo-code">
            <button type="button" onclick="applyPromoCode()"><span>Sử dụng</span></button>
            <p>Tạm tính: <?php echo number_format($total, 0, ',', '.') ?>.000VND</p>
            <p>Phí vận chuyển: <span id="ship"></p>
            <h3>Tổng cộng: <span id="total-price"></h3>
        </div>
    </div>
    <script>
        function applyPromoCode() {
            const promoCode = document.getElementById('promo-code').value;
            alert('Đã áp dụng mã giảm giá ' + promoCode + ' thành công!');
        }

        // cập nhật phí ship
        function updateShip() {
            const shipElement = document.getElementById('ship');
            const totalPriceElement = document.getElementById('total-price');
            const deliveryOption = document.querySelector('input[name="delivery_option"]:checked').value;

            if (deliveryOption === 'home') {
                shipElement.textContent = '35.000VND';
                totalPriceElement.textContent = '<?php echo number_format($total + 35, 0, ',', '.') ?>.000VND';
            } else {
                shipElement.textContent = '0 VND';
                totalPriceElement.textContent = '<?php echo number_format($total, 0, ',', '.') ?>.000VND';
            }
        }

        const deliveryOption = document.getElementsByName('delivery_option');
        const addressFields = document.querySelector('.address-fields');
        const storeAddress = document.querySelector('.store-address');

        deliveryOption.forEach(option => {
            option.addEventListener('change', function() {
                if (this.value === 'home') {
                    addressFields.style.display = 'block';
                    storeAddress.style.display = 'none';
                } else {
                    addressFields.style.display = 'none';
                    storeAddress.style.display = 'block';
                    document.getElementById('address').value = '';
                    document.getElementById('province').value = '';
                    document.getElementById('district').value = '';
                    document.getElementById('ward').value = '';
                }
                updateShip();
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var province = document.getElementById("province");
        var district = document.getElementById("district");
        var ward = document.getElementById("ward");

        axios.get("https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json")
            .then(function(response) {
                var data = response.data;
                renderProvince(data);
            });

        function renderProvince(data) {
            for (const item of data) {
                province.options[province.options.length] = new Option(item.Name, item.Id);
            }
            province.onchange = function() {
                district.length = 1;
                ward.length = 1;
                if (this.value !== "") {
                    const result = data.filter(n => n.Id === this.value);
                    for (const item of result[0].Districts) {
                        district.options[district.options.length] = new Option(item.Name, item.Id);
                    }
                }
            };
            district.onchange = function() {
                ward.length = 1;
                const result = data.filter(n => n.Id === province.value);
                if (this.value !== "") {
                    const wardsData = result[0].Districts.filter(n => n.Id === this.value)[0].Wards;
                    for (const item of wardsData) {
                        ward.options[ward.options.length] = new Option(item.Name, item.Id);
                    }
                }
            };
        }
    </script>
</body>

</html>