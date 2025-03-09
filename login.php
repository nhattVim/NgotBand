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

$noti = "";

if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM register WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $noti = "Tên người dùng đã tồn tại. Vui lòng sử dụng một tên khác.";
    } else {
        $sql = "INSERT INTO register (username, email, password) VALUES ('$username', '$email', '$password')";
        $sql1 = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE && $conn->query($sql1)) {

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lamhuynhgaming@gmail.com';
            $mail->Password = 'jwcg rcrp msry mppw';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('lamhuynhgaming@gmail.com', 'Ngọt');
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Ngọt - Đăng ký thành công';
            $mail->Body = '<strong> ' . $username . ' đã đăng ký thành công.</strong> <br> <br>
            <strong>Chúc bạn có thời gian trãi nghiệm trang web siêu tuyệt vời này của chúng tôi một cách sảng khoái nhất :D</strong>';

            $mail->send();

            $noti = "Đăng ký thành công!";
        } else {
            $noti = "Lỗi: " . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        header("Location: home.php");
        exit();
    } else {
        $noti = "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin đăng nhập.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập & Đăng ký</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png">
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signIn-signUp">
                <form action="#" method="post" class="sign-in-form">
                    <h2 class="title">Đăng nhập</h2>
                    <div class="input-field">
                        <i class='bx bx-user'></i>
                        <input type="text" name="username" placeholder="Tên người dùng">
                    </div>
                    <div class="input-field">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <input type="submit" id="login" name="login" value="Đăng nhập" class="btn solid">
                    <p class="social-text">Hoặc đăng nhập bằng:</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="bx bxl-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-linkedin"></i>
                        </a>
                    </div>

                    <div>
                        <br>
                        <p style="color: red; font-weight: bold;"><?php echo $noti ?></p>
                    </div>
                </form>
                <form action="#" method="post" class="sign-up-form">
                    <h2 class="title">Đăng ký</h2>
                    <div class="input-field">
                        <i class='bx bx-user'></i>
                        <input type="text" name="username" placeholder="Tên người dùng">
                    </div>
                    <div class="input-field">
                        <i class='bx bx-envelope'></i>
                        <input type="email" name="email" placeholder="Email">
                    </div>
                    <div class="input-field">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <input type="submit" id="register" name="register" value="Đăng ký" class="btn solid">
                    <p class="social-text">Hoặc đăng nhập bằng:</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="bx bxl-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bx bxl-linkedin"></i>
                        </a>
                    </div>

                    <div>
                        <br>
                        <p style="color: red; font-weight: bold;"><?php echo $noti ?></p>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Bạn chưa có tài khoản?</h3>
                    <p>Chào mừng đến với nền tảng của chúng tôi! Nếu bạn
                        chưa có tài khoản, bạn có thể đăng ký miễn phí.</p>
                    <button class="btn transparent" id="sign-up-btn">Đăng ký</button>
                </div>
                <a href="index.html"><img src="./assets/img/login/logo.png" alt="" class="img"></a>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Bạn đã có tài khoản rồi?</h3>
                    <p>Hãy nhấn vào nút đăng nhập, điền tên người dùng và mật khẩu để truy cập vào tài khoản của bạn.</p>
                    <button class="btn transparent" id="sign-in-btn">Đăng nhập</button>
                </div>
                <a href="index.html"><img src="./assets/img/login/logoha.png" alt="" class="img"></a>
            </div>
        </div>
    </div>
    <script>
        const sign_in = document.querySelector("#sign-in-btn");
        const sign_up = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");

        sign_up.addEventListener('click', () => {
            container.classList.add('sign-up-mode');
        });

        sign_in.addEventListener('click', () => {
            container.classList.remove('sign-up-mode');
        });
    </script>
</body>

</html>