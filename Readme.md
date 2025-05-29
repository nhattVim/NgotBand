<h1 align="center">NGOTBAND</h1>

<p align="center"><em>Empower Your Music Journey with Seamless Shopping</em></p>

<p align="center">
  <img src="https://img.shields.io/badge/last%20commit-today-brightgreen" />
  <img src="https://img.shields.io/badge/php-74.7%25-blue" />
  <img src="https://img.shields.io/badge/languages-4-lightgrey" />
</p>

<br />

<p align="center"><em>Built with the tools and technologies:</em></p>

<p align="center">
  <img src="https://img.shields.io/badge/-Markdown-black?logo=markdown" />
  <img src="https://img.shields.io/badge/-PHP-777BB4?logo=php&logoColor=white" />
</p>

---

# Table of Content

-   [Table of Content](#table-of-content)
    -   [🌐 Trang web](#-trang-web)
    -   [👥 Thành viên](#-thành-viên)
    -   [🖼️ Screenshots](#️-screenshots)
    -   [💻 Hướng dẫn cài đặt (Local với XAMPP)](#-hướng-dẫn-cài-đặt-local-với-xampp)

---

## 🌐 Trang web

Đây là phiên bản web giúp người dùng trải nghiệm hành trình âm nhạc với hệ thống mua sắm liền mạch: [ngotband.fwh.is](https://ngotband.fwh.is)

---

## 👥 Thành viên

-   **Huỳnh Ngọc Lâm** – Backend, Cơ sở dữ liệu
-   **Lưu Minh Chí** – Frontend, Thiết kế
-   **Lê Nhật Trường** – Xử lý media, nén video
-   **Trần Thị Ngọc Mai** – Tài liệu, thử nghiệm
-   **Trần Phi Hùng (80)** – Tài liệu, thử nghiệm

---

## 🖼️ Screenshots

<div align="center">
    <table>
        <tr>
            <td><img src="https://github.com/nhattVim/assets/blob/master/NgotBand/1.png?raw=true"/></td>
            <td><img src="https://github.com/nhattVim/assets/blob/master/NgotBand/2.png?raw=true"/></td>
        </tr>
    </table>
    <table>
        <tr>
            <td><img src="https://github.com/nhattVim/assets/blob/master/NgotBand/3.png?raw=true"/></td>
            <td><img src="https://github.com/nhattVim/assets/blob/master/NgotBand/4.png?raw=true"/></td>
            <td><img src="https://github.com/nhattVim/assets/blob/master/NgotBand/5.png?raw=true"/></td>
        </tr>
    </table>
</div>

---

## 💻 Hướng dẫn cài đặt (Local với XAMPP)

1. **Tải XAMPP và cài đặt:**
   [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)

2. **Di chuyển mã nguồn vào thư mục `htdocs`:**

    ```bash
    C:\xampp\htdocs\NgotBand\
    ```

3. **Tạo cơ sở dữ liệu:**

-   Truy cập http://localhost/phpmyadmin
-   Tạo database mới tên ngot_database

4. **Import dữ liệu:**

-   Chọn database ngot_database
-   Chọn Import → chọn file:

    ```
    assets/database/ngot_database.sql
    ```

5. **Chạy dự án trên trình duyệt:**
