<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$product_id = isset($_GET['id_product']) ? $_GET['id_product'] : null;

$sql = "SELECT * FROM product_info WHERE id_product = '$product_id'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_product = $row['id_product'];
        $name_product = $row['name_product'];
        $img_product = $row['img_1'];
        $price = $row['price'];
        $sl_order = $_POST['quantity'];
        $total = $price * $sl_order;

        $sql_check = "SELECT * FROM cart_product WHERE id_product = '$id_product'";
        $check_result = $conn->query($sql_check);

        if ($check_result->num_rows > 0) {
            $sql_update = "UPDATE cart_product SET sl_order = sl_order + $sl_order WHERE id_product = '$id_product'";
            $sql_update1 = "UPDATE cart_product SET total = total + $total WHERE id_product = '$id_product'";
            if ($conn->query($sql_update) === TRUE and $conn->query($sql_update1) === TRUE) {
                $current_url = $_SERVER['REQUEST_URI'];
                header("Location: $current_url");
                exit();
            } else {
                echo "Lỗi: " . $sql_update . "<br>" . $conn->error;
            }
        } else {
            $sql_insert = "INSERT INTO cart_product (id_product, name_product, img_product, price, sl_order, total)
                            VALUES ('$id_product', '$name_product', '$img_product', $price, $sl_order, $total)";

            if ($conn->query($sql_insert) === TRUE) {
                $current_url = $_SERVER['REQUEST_URI'];
                header("Location: $current_url");
                exit();
            } else {
                echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    }
}

$sql1 = "SELECT COALESCE(SUM(sl_order), 0) AS total_quantity FROM cart_product";
$result1 = $conn->query($sql1);
$row = $result1->fetch_assoc();
$totalQuantity = $row['total_quantity'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngọt - Chi tiết</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png">
</head>

<body>
    <div class="wrap">
        <header>
            <div class="logo">
                <a href="index.html"><img src="./assets/img/logo/logo.png" alt="logo.img"></a>
            </div>

            <div class="header__nav-section">
                <div class="header__nav-cart">
                    <a href="buy.php" class="header__nav-cart-link">
                        <span class="header__nav-cart-count"><?php echo $totalQuantity; ?></span>
                        <i class="header__nav-cart-icon fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
                <div class="header__nav-login">
                    <a href="login.php" class="header__nav-login-link">
                        <i class="header__nav-login-icon fa-regular fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
            <div class="product-detail-wrapper">
                <div class="product-list-wrap">
                    <div class="product-list">
                        <?php
                        if ($result->num_rows > 0) {
                            echo "<div class='product-item'>";
                            echo "<a href=''><img src='./assets/img/shop/" . $row["img_1"] . "' alt='Product Image'></a>";
                            if (!empty($row["img_2"])) {
                                echo "<a href=''><img src='./assets/img/shop/" . $row["img_2"] . "' alt='Product Image'></a>";
                            }
                            if (!empty($row["img_3"])) {
                                echo "<a href=''><img src='./assets/img/shop/" . $row["img_3"] . "' alt='Product Image'></a>";
                            }
                            if (!empty($row["img_4"])) {
                                echo "<a href=''><img src='./assets/img/shop/" . $row["img_4"] . "' alt='Product Image'></a>";
                            }
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="product-image-detail">
                    <ul class="slide-product">
                        <?php
                        if (!empty($row["img_1"])) {
                            echo "<li><img src='./assets/img/shop/" . $row["img_1"] . "' alt=''></li>";
                        }
                        if (!empty($row["img_2"])) {
                            echo "<li><img src='./assets/img/shop/" . $row["img_2"] . "' alt=''></li>";
                        }
                        if (!empty($row["img_3"])) {
                            echo "<li><img src='./assets/img/shop/" . $row["img_3"] . "' alt=''></li>";
                        }
                        if (!empty($row["img_4"])) {
                            echo "<li><img src='./assets/img/shop/" . $row["img_4"] . "' alt=''></li>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="info-wrap">
                    <div class="info">
                        <div class="product-title">
                            <h1><?php echo $row["name_product"]; ?></h1>
                            <div class="name-product">
                                <div>
                                    <span><strong>Ngọt</strong></span>
                                </div>
                                <?php echo nl2br($row["info_short"]); ?>
                            </div>
                        </div>
                        <div class="product-price">
                            <span><?php echo $row["price"] . ".000VND"; ?></span>
                        </div>
                        <form action="" id="add-item-form" method="post">
                            <div class="quantity-area">
                                <button style="width: 25px; background-color: white;" type="button" value="-" class="qty-btn">-</button>
                                <input type="text" min="1" class="quantity-selector" name="quantity" id="quantity">
                                <button style="width: 25px; background-color: white;" type="button" value="+" class="qty-btn">+</button>
                            </div>
                            <div class="wrap-addcart">
                                <button type="submit" class="add-btn"><span>THÊM VÀO GIỎ</span></button>
                            </div>
                        </form>
                        <div class="product-decs">
                            <div class="title-bl">
                                <h2>Mô tả</h2>
                            </div>
                            <div class="decs-content">
                                <?php echo nl2br($row["info_long"]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <div class="content-product-list">
            <div class="content-product-item">
                <div class="image">
                    <a href="products.php?id_product=aotrang"><img src="https://product.hstatic.net/200000777655/product/a1_30cb4419667446b0927265534a35c0bb.jpg" alt=""></a>
                </div>
                <div class="product-detail">
                    <h3><a href="products.php?id_product=aotrang">KẸO CRACKED LOGO TEE - WHITE</a></h3>
                    <a href="products.php?id_product=aotrang">
                        <h3>435.000VND</h3>
                    </a>
                </div>
            </div>
            <div class="content-product-item">
                <div class="image">
                    <a href="products.php?id_product=aoden"><img src="https://product.hstatic.net/200000777655/product/a2_99543f2d74d94b09bd4106e993cc0491.jpg" alt=""></a>
                </div>
                <div class="product-detail">
                    <h3><a href="products.php?id_product=aoden">KẸO CRACKED LOGO TEE - BLACK</a></h3>
                    <a href="products.php?id_product=aoden">
                        <h3>435.000VND</h3>
                    </a>
                </div>
            </div>
            <div class="content-product-item">
                <div class="image">
                    <a href="products.php?id_product=tattrang"><img src="https://product.hstatic.net/200000777655/product/tat_linh1_691569a7997b4353a7eb1e49c62e9e31.jpg" alt=""></a>
                </div>
                <div class="product-detail">
                    <h3><a href="products.php?id_product=tattrang">KẸO PATTERN SOCKS</a></h3>
                    <a href="products.php?id_product=tattrang">
                        <h3>135.000VND</h3>
                    </a>
                </div>
            </div>
            <div class="content-product-item">
                <div class="image">
                    <a href="products.php?id_product=pin"><img src="https://product.hstatic.net/200000777655/product/p2_778ed0175a724cce8d09e72652730936.jpg" alt=""></a>
                </div>
                <div class="product-detail">
                    <h3><a href="products.php?id_product=pin">KẸO PIN</a></h3>
                    <a href="products.php?id_product=pin">
                        <h3>115.000VND</h3>
                    </a>
                </div>
            </div>
            <div class="content-product-item">
                <div class="image">
                    <a href="products.php?id_product=pop"><img src="https://product.hstatic.net/200000777655/product/p4_d5b7d85dbe334ccbaf4ba61f3f263b32.jpg" alt=""></a>
                </div>
                <div class="product-detail">
                    <h3><a href="products.php?id_product=pop">KẸO POPSOCKETS</a></h3>
                    <a href="products.php?id_product=pop">
                        <h3>115.000VND</h3>
                    </a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var quantityInput = document.getElementById('quantity');
            var decrementBtn = document.querySelector('.qty-btn[value="-"]');
            var incrementBtn = document.querySelector('.qty-btn[value="+"]');

            quantityInput.value = 1;

            decrementBtn.addEventListener('click', function() {
                var currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            incrementBtn.addEventListener('click', function() {
                var currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });
        });
    </script>
</body>

</html>