<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id_bill, name, phone, total FROM bill ORDER BY id_bill DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $phone = $row["phone"];
    $id_bill = $row["id_bill"];
    $total = $row["total"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngọt - Thành công</title>
    <link rel="stylesheet" href="./assets/css/succesful.css">
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png">
</head>

<body>
    <header class="header">
        <div class="header__logo">
            <a href="index.html"><img src="./assets/img/logo/logo.png" alt="" class ="header__logo--photograp"></a>
        </div>
    </header>
    <div class="success-container">
        <h1>Ghi nhận thành công!</h1>
        <p>Cảm ơn <?php echo $name ?> đã đặt hàng. Đơn hàng của <?php echo $name ?> đã được xử lý thành công.</p>
        <p>Một email xác nhận đã được gửi đến địa chỉ email của <?php echo $name ?>.</p>
        <a href="index.html"><button><span>Quay lại trang chủ</span></button></a>
    </div>

    <div class="qr">
        <img src="./assets/img/succesful/qr_code.png" alt="QR Code">
        <div class="payment-info">
            <p><strong>Tổng tiền: </strong><?php echo number_format($total + 35, 0, ',', '.') ?>.000VND</p>
            <p><strong>Nội dung chuyển khoản:</strong></p>
            <p><?php echo $name ?> + <?php echo $phone ?> + <?php echo $id_bill ?></p>
        </div>
    </div>
</body>

</html>