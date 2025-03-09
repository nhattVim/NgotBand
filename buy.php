<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT * FROM cart_product";
$result = $conn->query($sql);

$sql1 = "SELECT COALESCE(SUM(sl_order), 0) AS total_quantity FROM cart_product";
$result1 = $conn->query($sql1);
$row = $result1->fetch_assoc();
$totalQuantity = $row['total_quantity'];

$sql2 = "SELECT COALESCE(SUM(total), 0) AS total_price FROM cart_product";
$result2 = $conn->query($sql2);
$row = $result2->fetch_assoc();
$totalPrice = $row['total_price'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngọt - Giỏ hàng</title>
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon_1.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="./assets/CSS/buy.css">
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png">
</head>
<body>
    <div class="wrap">
        <header class="header">
            <div class="header__logo">
                <a href="index.html"><img src="./assets/img/logo/logo.png" alt="" class="header__logo-photograp"></a>
            </div>

            <div class="header__cart-buy">
                <i class="header__cart-icon fa-solid fa-cart-shopping"></i>
                <span class="header__cart-count"><?php echo $totalQuantity; ?></span>
            </div>
        </header>

        <div class="main__content-theme">
            <div class="main__content--heading-page">
                <h1 class="main__content--heading-title">Giỏ hàng của bạn</h1>
                <p class="main__content--heading--count-cart">Có <span><?php echo $totalQuantity; ?> sản phẩm</span> trong giỏ hàng</p>
            </div>
        </div>

        <div class="wrap__box-content-cart">
            <div class="wrap__box-content-container">
                <form action="" id="carformpage">
                    <table class="wrap__box-content-table">
                        <thead>
                            <tr>
                                <th class="image"></th>
                                <th class="Item"></th>
                                <th class="remove"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $total = $row["price"] * $row["sl_order"];
                                    echo '<tr class="wrap__box-content-dirc">';
                                    echo '<td class="image">';
                                    echo '<div class="product-img">';
                                    echo '<a href="products.php?id_product=' . $row['id_product'] . '"><img src="./assets/img/shop/' . $row["img_product"] . '" alt=""></a>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '<td class="Item">';
                                    echo '<h3><a href="products.php?id_product=' . $row['id_product'] . '">' . $row["name_product"] . '</a></h3>';
                                    echo '<p><span class="pri">' . $row["price"] . '.000VND</span></p>';
                                    echo '<div class="line__item-container--click-parent">';
                                    echo '<button class="qlyminus qly-btn"><i class="qlyminus-icon fa-solid fa-minus"></i></button>';
                                    echo '<input type="text" name="amount" class="line__item-qty" value="' . $row["sl_order"] . '" readonly>';
                                    echo '<button class="qluplus qly-btn"><i class="qluplus-icon fa-solid fa-plus"></i></button>';
                                    echo '</div>';
                                    echo '<p class="price"><span class="line__item-total">' . number_format($total, 0, ',', '.') . '.000VND</span></p>';
                                    echo '</td>';
                                    echo '<td class="remove"><a href="" class="cart"><i class="fa-solid fa-xmark"></i></a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Không có gì cả</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="wrap__box-content--box-ground">
                        <h4>Ghi chú đơn hàng</h4>
                        <div class="wrap__box-content--checkout-note">
                            <textarea  name="note" id="node" placeholder="Ghi chú"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="wrap__sticky">

                <div class="wrap__box-line--order">
                    <div class="wrap__box-line--order-title">
                        <h3>Thông tin đơn hàng</h3>
                    </div>
                    <div class="wrap__box-line--order-total">
                        <p>
                            Tổng tiền : <span class="tatal-price"><?php echo number_format($totalPrice, 0, ',', '.') ?>.000VND</span>
                        </p>
                    </div>
                    
                    <div class="wrap__box-line--order-text">
                        <p>
                            Phí vận chuyển sẽ được tính ở trang thanh toán. <br>
                            Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.
                        </p>
                    </div>
                    <div class="wrap__box-line--order-action">
                        <a href="payment.php" class="buttom wrap__box-line--order-btn-checkout">
                            Thanh toán
                        </a>
                        
                        <p class="wrap__box-line--order-continue">
                            <a href="cart.php" class="wrap__box-line--order-link">
                                <i class="wrap__box-line--order-icon fa-solid fa-reply"></i>
                                Tiếp tục mua hàng
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
            
            <footer>
                <div class="main-footer">
                <div class="footer-content">
                    <div class="footer-content-left">
                        <p>
                            HKD Uglyborn <br>
                            GPKD số 01D8051722 cấp ngày 12/10/2023 <br>
                            tại UBND quận Hai Bà Trưng <br>
                            Địa chỉ: phường Đống Đa, thành phố Quy Nhơn, tỉnh Bình Định<br>
                            Email: lamhuynhgaming@gmail.com <br>
                            Hotline: 0935 388 971
                            <br>
                        </p>
                        <div class="logo-footer">
                            <a href="http://online.gov.vn/Home/WebDetails/110866">
                                <img src="//theme.hstatic.net/200000777655/1001125616/14/logo_bct.png?v=221" alt="footer-logo">
                            </a>
                        </div>
                        <ul class="footer-social">
                            <li><a href="https://www.facebook.com/bannhacngot"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="https://www.instagram.com/bannhac.ngot"><i class="fa-brands fa-instagram"></i></i></a></li>
                            <li><a href="https://www.youtube.com/@Ngotband"><i class="fa-brands fa-youtube"></i></i></i></a></li>
                        </ul>
                    </div>
                    <div class="footer-content-right">
                        <ul>
                            <li><a href="">Hướng dẫn mua hàng</a></li>
                            <li><a href="">Hình thức thanh toán</a></li>
                            <li><a href="">Chính sách giao hàng</a></li>
                            <li><a href="">Chính sách bảo hành - đổi trả</a></li>
                            <li><a href="">Chính sách bảo mật thông tin</a></li>
                            <li><a href="">Chính sách kiểm hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>Copyright © 2024 </p>
                <a href="index.html">Ngọt</a>
            </div>
        </footer>
    </div>
</body>
</html>