<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_POST['add_song'])) {
    $id_song = $_POST['add_song'];

    $check_query = "SELECT * FROM song WHERE id_song = '$id_song' AND id_album = '1'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>
                alert('Bài hát này đã tồn tại trong album');
                window.history.back();
              </script>";
    } else {
        $sql = "SELECT name_song, author, time, poster, file, lyrics FROM song WHERE id_song = '$id_song'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name_song = $row['name_song'];
            $author = $row['author'];
            $time = $row['time'];
            $poster = $row['poster'];
            $file = $row['file'];
            $lyrics = $row['lyrics'];

            $sql_insert = "INSERT INTO song (id_song, name_song, author, time, poster, file, lyrics, id_album) VALUES ('$id_song', '$name_song', '$author', '$time', '$poster', '$file', '$lyrics', '1')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "<script>
                        alert('Thêm bài hát thành công');
                        window.history.back();
                      </script>";
            } else {
                echo "Lỗi: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    }
}

if (isset($_POST['remove_song'])) {
    $id_song = $_POST['remove_song'];

    $sql_delete = "DELETE FROM song WHERE id_song = '$id_song' AND id_album = '1'";

    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>
                alert('Xoá bài hát thành công. Hãy load lại trang =)))');
                window.history.back();
              </script>";
    } else {
        echo "Lỗi: " . $sql_delete . "<br>" . $conn->error;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ngọt - Nhạc</title>
    <link rel="stylesheet" href="assets/css/reset.css" />
    <link rel="stylesheet" href="assets/css/music.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="./assets/img/logo/web.png" />
</head>

<body>
    <div id="main">
        <div id="left">
            <div id="sidebar">
                <div id="sidebar-top">
                    <div class="logo">
                        <a href="index.html"><img src="./assets/img/logo/logo.png" alt="img" /></a>
                    </div>
                    <ul>
                        <li>
                            <a href="home.php">
                                <button id="btn-home" type="submit">
                                    <i class="icon fa-solid fa-house fa-xl"></i>
                                    <h5>Home</h5>
                                </button>
                            </a>
                        </li>
                        <li>
                            <a href="search.php">
                                <button id="btn-search" type="submit">
                                    <i class="icon fa-solid fa-magnifying-glass fa-xl"></i>
                                    <h5>Search</h5>
                                </button>
                            </a>
                        </li>
                        <li>
                            <a href="music.php?id_album=1">
                                <button id="btn-library" type="submit">
                                    <i class="icon fa-solid fa-lines-leaning fa-xl"></i>
                                    <h5>Library</h5>
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="sidebar-bottom">
                    <div class="playlist-head">
                        <a class="playlist-headl" href="#">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        </a>
                        <a class="playlist-headr" href="#">
                            <h4>Gần đây</h4>
                            <i class="fa-solid fa-list" aria-hidden="true"></i>
                        </a>
                    </div>
                    <ul>

                        <?php
                        $sql_albums = "SELECT id_album, name_album, img_album, sl_song FROM album WHERE type = 'album' || type = 'single' || type = 'playlist'";
                        $result_albums = $conn->query($sql_albums);

                        if ($result_albums->num_rows > 0) {
                            while ($row_album = $result_albums->fetch_assoc()) {
                                $id_album = $row_album["id_album"];
                                $name_album = $row_album["name_album"];
                                $img_album = $row_album["img_album"];

                                $sql_count = "SELECT COUNT(*) AS sl_song FROM song WHERE id_album = '$id_album'";
                                $result_count = $conn->query($sql_count);
                                $row_count = $result_count->fetch_assoc();
                                $sl_song = $row_count['sl_song'];
                                echo '<li>
                                <a href="music.php?id_album=' . $id_album . '">
                        <img src="./assets/img/music/' . $img_album . '" alt="img" />
                        <h5>
                            ' . $name_album . '
                            <div class="subtitle">' . $sl_song . ' bài hát</div>
                        </h5>
                    </a>
                </li>';
                            }
                        } else {
                            echo '<li>Không có album</li>';
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
        <div id="center">
            <div id="layout">
                <div id="content">
                    <div id="header">
                        <div id="h-left">
                            <ul>
                                <li><a href="music.php?id_album=newin">New in</a></li>
                                <li><a href="music.php?id_album=trending">Trending</a></li>
                                <li><a href="music.php?id_album=hit">Recommended</a></li>
                            </ul>
                        </div>
                        <div id="h-right">
                            <div class="first-item">
                                <i class="icon fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Tìm kiếm" class="input-field" />
                                <div class="search-result"></div>
                            </div>
                            <a class="second-item" href="#">
                                <i class="fa-solid fa-bell"></i>
                            </a>
                            <a class="last-item" href="#">
                                <img src="./assets/img/music/lamhuynh.png" alt="user" />
                            </a>
                        </div>
                    </div>
                    <div id="banner">
                        <?php
                        $id_album = isset($_GET['id_album']) ? $_GET['id_album'] : null;

                        if ($id_album) {
                            $sql_album = "SELECT name_album, img_album, author, sl_song, year, type FROM album WHERE id_album = '$id_album'";
                            $result_album = $conn->query($sql_album);

                            if ($result_album->num_rows > 0) {
                                $row_album = $result_album->fetch_assoc();
                                $name_album = $row_album['name_album'];
                                $img_album = $row_album['img_album'];
                                $type = $row_album['type'];
                                $author = $row_album['author'];
                                $year = $row_album['year'];

                                $sql_count = "SELECT COUNT(*) AS sl_song FROM song WHERE id_album = '$id_album'";
                                $result_count = $conn->query($sql_count);
                                $row_count = $result_count->fetch_assoc();
                                $sl_song = $row_count['sl_song'];
                            }
                        }
                        ?>
                        <div class="banner-img">
                            <img style="border-radius: 20px;" src="./assets/img/music/<?php echo $img_album; ?>" alt="img" />
                        </div>
                        <div class="banner-content">
                            <div class="banner-title">
                                <h4><?php echo $type; ?></h4>
                                <h2><?php echo $name_album; ?></h2>
                                <h6><?php echo $author . ' • ' . $year . ' • ' . $sl_song . ' bài hát'; ?></h6>
                            </div>
                        </div>
                        <div class="icon">
                            <button type="button">
                                <i class="fa-solid fa-circle-play"></i>
                            </button>
                            <button type="button">
                                <i class="fa-solid fa-heart" ></i>
                            </button>
                            <button type="button">
                                <i class="fa-solid fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                    <div id="album">
                        <table>
                            <thead>
                                <th>#</th>
                                <th>Tiêu đề</th>
                                <th></th>
                                <th>Thời gian</th>
                            </thead>
                            <tbody>
                                <?php
                                $id_album = isset($_GET['id_album']) ? $_GET['id_album'] : null;
                                $sql = "SELECT id_song, name_song, author, poster, time FROM song WHERE id_album = '$id_album'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $stt = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $id_song = $row["id_song"];
                                        $name_song = $row["name_song"];
                                        $author = $row["author"];
                                        $img = $row["poster"];
                                        $duration = $row["time"];
                                        $button_type = $id_album === '1' ? 'remove_song' : 'add_song';
                                        $button_icon = $id_album === '1' ? 'fa-minus' : 'fa-plus';

                                        echo '<tr id="' . $id_song . '">
                <td class="stt">' . $stt . '</td>
                <td>
                    <div class="mv-item">
                        <div class="mv-item-content">
                            <a href="#"><strong>' . $name_song . '</strong></a>
                            <a href="#"><p>' . $author . '</p></a>
                        </div>
                    </div>
                </td>
                <td>
                    <form method="post" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">
                    <button style="background-color: transparent; border: none; padding: 10px" type="submit" name="' . $button_type . '" value="' . $id_song . '"><i class="fa-solid ' . $button_icon . '"></i></button>
                    </form>
                </td>
                <td>' . $duration . '</td>
            </tr>';
                                        $stt++;
                                    }
                                } else {
                                    echo '<tr><td colspan="4">Không có bài hát nào trong album này</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="mv">
                        <div class="mv-header">
                            <h1 class="section-title">MV</h1>
                            <div class="btn-scroll">
                                <i id="left-scroll-mv" class="fa fa-arrow-left" aria-hidden="true"></i>
                                <i id="right-scroll-mv" class="fa fa-arrow-right" aria-hidden="true"></i>
                            </div>
                        </div>

                        <?php
                        $sql_songs = "SELECT id_mv, name_mv, img_mv, file FROM mv WHERE id_album = '$id_album'";
                        $result_songs = $conn->query($sql_songs);
                        $songs = array();

                        if ($result_songs->num_rows > 0) {
                            while ($row_song = $result_songs->fetch_assoc()) {
                                $songs[] = array(
                                    'id' => $row_song['id_mv'],
                                    'name' => $row_song['name_mv'],
                                    'img' => $row_song['img_mv'],
                                    'file' => $row_song['file']
                                );
                            }
                        } else {
                            echo 'Không có MV nào trong album này';
                        }

                        ?>

                        <div class="pop-mv">
                            <?php foreach ($songs as $song) { ?>
                                <div class="pop-mv-item">
                                    <a href="#" data-video="./assets/video/video_music/<?php echo $song['file']; ?>" class="btn-mv">
                                        <img src="./assets/img/mv/<?php echo $song['img']; ?>" alt="img" />
                                        <h3><?php echo $song['name']; ?></h3>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>


                        <div id="other-album">
                            <div class="scroll-bar">
                                <h2>Album Khác</h2>
                                <div class="btn-scroll">
                                    <i id="left-scroll-album" class="fa fa-arrow-left" aria-hidden="true"></i>
                                    <label for=""> </label>
                                    <i id="right-scroll-album" class="fa fa-arrow-right" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="pop-album">
                                <div class="album-item">
                                    <a href="music.php?id_album=ngot">
                                        <img style="border-radius: 20px;" src="./assets/img/music/ngot.jpg" alt="" />
                                        <h3>Ngọt</h3>
                                        <h4>2016</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=ngbthg">
                                        <img style="border-radius: 20px;" src="./assets/img/music/ngbthg.jpg" alt="" />
                                        <h3>Ng'bthg</h3>
                                        <h4>2018</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=3">
                                        <img style="border-radius: 20px;" src="./assets/img/music/3.jpeg" alt="" />
                                        <h3>3 (tuyển tập ...</h3>
                                        <h4>2019</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=gieo">
                                        <img style="border-radius: 20px;" src="./assets/img/music/gieo.jpg" alt="" />
                                        <h3>Gieo</h3>
                                        <h4>2022</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=suyt1">
                                        <img style="border-radius: 20px;" src="./assets/img/music/suyt1.jpg" alt="" />
                                        <h3>Suýt 1</h3>
                                        <h4>2024</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=caidautien">
                                        <img style="border-radius: 20px;" src="./assets/img/music/caidautien.jpg" alt="" />
                                        <h3>Cái Đầu Tiên</h3>
                                        <h4>2023</h4>
                                    </a>
                                </div>
                                <div class="album-item">
                                    <a href="music.php?id_album=giaytrang">
                                        <img style="border-radius: 20px;" src="./assets/img/music/giaytrang.jpeg" alt="" />
                                        <h3>Giấy Trắng</h3>
                                        <h4>2022</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer>
                    <div class="footer-content">
                        <div class="footer-info">
                            <p>Địa chỉ: Quy Nhơn</p>
                            <p>
                                Hotline: 0935 388 971 <span></span> Email:
                                lamhuynhgaming@gmail.com
                            </p>
                            <p>
                                GPKD số 01D8051722 cấp ngày 12/10/2023 tại
                                UBND quận Hai Bà Trưng
                            </p>
                        </div>
                        <div class="footer-logo">
                            <a href="http://online.gov.vn/Home/WebDetails/110866">
                                <img src="./assets/img/footer/footer.png" alt="footer-logo" />
                            </a>
                        </div>
                        <div class="footer-link">
                            <div class="footer-social-list">
                                <a href="https://www.facebook.com/bannhacngot"><i class="fa-brands fa-facebook"></i></a>
                                <a href="https://www.youtube.com/c/Ngß╗ìtband"><i class="fa-brands fa-youtube"></i></a>
                                <a href="https://music.apple.com/us/artist/ngß╗ìt/1291453081"><i class="fa-solid fa-music"></i></a>
                                <a href="https://open.spotify.com/artist/0V2DfUrZvBuUReS1LFo5ZI"><i class="fa-brands fa-spotify"></i></a>
                            </div>
                            <div class="footer-text-link">
                                <p>@2024 Lâm Huỳnh</p>
                                <ul>
                                    <li><a href="#">Terms</a></li>
                                    <li><a href="#">Privacy</a></li>
                                    <li><a href="#">Cookie choices</a></li>
                                    <li><a href="#">Do not sell or share my personal information</a></li>
                                </ul>
                                <p>IF YOU ARE USING A SCREEN READER AND ARE HAVING PROBLEMS USING THIS WEBSITE, PLEASE
                                    CALL
                                    0935388971 FOR ASSISTANCE.</p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <div id="right">
                <div id="music-bar">
                    <div id="music-img">
                        <img id="music-img-img" src="./assets/img/music/dunglamtraitimanhdau.jpeg" alt="img" />
                    </div>
                    <div id="music-content">
                        <div id="title">
                            <strong>Đừng Làm Trái Tim Anh Đau</strong>
                            <p>Sơn Tùng M-TP</p>
                        </div>
                        <div class="player">
                            <div class="control">
                                <div class="btn btn-repeat">
                                    <i class="fas fa-redo"></i>
                                </div>
                                <div class="btn btn-prev">
                                    <i class="fa-solid fa-backward-step" id="playBack"></i>
                                </div>
                                <div class="btn btn-toggle-play">
                                    <i class="fa-solid fa-play" id="playMaster"></i>
                                </div>
                                <div class="btn btn-next">
                                    <i class="fa-solid fa-forward-step" id="playNext"></i>
                                </div>
                                <div class="btn btn-random">
                                    <i class="fas fa-random"></i>
                                </div>
                            </div>
                        </div>

                        <input id="progress" class="progress" type="range" value="0" step="1" min="0" max="100" />

                        <div class="timer">
                            <div class="duration">0:00</div>

                            <div class="volume-control">
                                <i class="fa-solid fa-volume-high" id="volume-icon"></i>
                                <input type="range" id="volume-slider" min="0" max="100" value="100" step="1" class="volume-slider">
                            </div>

                            <div class="remaining">3:10</div>
                        </div>

                        <div id="lyrics-box">
                            <div class="lyrics-title">
                                <p>Lời bài hát</p>
                                <button type="button">
                                    <a href="#">Show lyrics</a>
                                </button>
                            </div>
                            <div class="lyrics-container">
                                <div class="lyrics">
                                    <p>Hình như trong lòng anh đã không còn hình bóng ai ngoài em đâu</p>
                                    <p>Hằng đêm anh nằm thao thức suy tư, chẳng nhớ ai ngoài em đâu</p>
                                    <p>Vậy nên không cần nói nữa, yêu mà đòi nói trong vài ba câu</p>
                                    <p>Cứ cố quá đâm ra lại hâm</p>
                                    <p>Uhm, đau hết cả đầu</p>
                                    <p>Đợi chờ em trước nhà từ sáng đến trưa chiều tối mắc màn đây luôn (Ah-ah-ah-ah)</p>
                                    <p>Ngược nắng hay là ngược gió, miễn anh thấy em tươi vui không buồn</p>
                                    <p>Chỉ cần có thấy thế thôi mây xanh chan hoà</p>
                                    <p>(Uhm) thấy thế thôi vui hơn có quà</p>
                                    <p>Và bước kế tiếp anh lại gần hơn chút đó nha</p>
                                    <p>Rồi ngày ấy cuối cùng đã tìm đến, ta nào đâu hay (Hay)</p>
                                    <p>Anh sẽ không để vụt mất đi cơ duyên ông trời trao tay</p>
                                    <p>Còn đắn đo băn khoăn gì nữa, tiếp cận em ngay (Ngay)</p>
                                    <p>Cố gắng sao không để em nghi ngờ dù một giây lúc này</p>
                                    <p>Được đứng bên em anh hạnh phúc, tim loạn nhịp tung bay (Bay)</p>
                                    <p>Chắc chắn anh thề anh sẽ không bao giờ quên ngày hôm nay</p>
                                    <p>Chính em, chính em, tương tư mình em thôi</p>
                                    <p>Mãi theo sau mình em thôi, mãi si mê mình em thôi</p>
                                    <p>(Mãi yêu thương mình em)</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Nên có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau</p>
                                    <p>Tình cờ lọt vào, nụ cười ngọt ngào (Ngào)</p>
                                    <p>Anh thề không biết đường thoát ra làm sao</p>
                                    <p>Lựa một lời chào phải thật là ngầu nào (Nào)</p>
                                    <p>Nay tự dưng sao toàn mấy câu tào lao</p>
                                    <p>Lại gần một chút cho anh ngắm nhìn người vài phút, say trong cơn mơ thiên đàng</p>
                                    <p>Quên đi chuyện của nhân gian, hoà vào trăng sao, tan theo miên man</p>
                                    <p>Nhiều lời rồi đấy nhé, dài dòng rồi đấy nhé</p>
                                    <p>Rồi cứ thế, vòng lặp lại cứ thế</p>
                                    <p>Lại bối rối, không xong là đến tối</p>
                                    <p>Nói luôn đi, "Đời này chỉ cần mình em thôi"</p>
                                    <p>Giấu hết nhớ nhung sâu trong lời nhạc, nối tiếp những áng thơ ngô nghê rời rạc</p>
                                    <p>Viết lên chuyện đôi ta vào một ngày không xa, ngày về chung một nhà</p>
                                    <p>Rồi ngày ấy cuối cùng đã tìm đến, ta nào đâu hay (Hay)</p>
                                    <p>Anh sẽ không để vụt mất đi cơ duyên ông trời trao tay</p>
                                    <p>Còn đắn đo băn khoăn gì nữa, tiếp cận em ngay (Ngay)</p>
                                    <p>Cố gắng sao không để em nghi ngờ dù một giây lúc này</p>
                                    <p>Được đứng bên em anh hạnh phúc, tim loạn nhịp tung bay (Bay)</p>
                                    <p>Chắc chắn anh thề anh sẽ không bao giờ quên ngày hôm nay</p>
                                    <p>Chính em, chính em, tương tư mình em thôi</p>
                                    <p>Mãi theo sau mình em thôi, mãi si mê mình em thôi</p>
                                    <p>(Mãi yêu thương mình em)</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Nên có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau</p>
                                    <p>Vậy thì anh xin chết vì người anh thương</p>
                                    <p>Có biết bao nhiêu điều còn đang vấn vương</p>
                                    <p>Dành cho em, dành hết ân tình anh mang một đời</p>
                                    <p>Đừng làm trái tim anh đau (Ooh, hey)</p>
                                    <p>La-la-la-la (hey), la-la-la-la-la-la-la</p>
                                    <p>La-la-la-la (hey), la-la-la-la-la-la-la</p>
                                    <p>La-la-la-la (okay), la-la-la-la-la-la-la</p>
                                    <p>(Đừng làm trái tim anh đau)</p>
                                    <p>One more time, one more time, one more time</p>
                                    <p>La-la-la-la (hey), la-la-la-la-la-la-la</p>
                                    <p>La-la-la-la (hey), la-la-la-la-la-la-la (Sơn Tùng M-TP)</p>
                                    <p>La-la-la-la (yeah, oh), la-la-la-la-la-la-la</p>
                                    <p>(Đừng làm trái tim anh đau)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("search_song.php") ?>

        <script>
            const song = document.getElementById("song");
            const left_scroll_mv = document.getElementById("left-scroll-mv");
            const right_scroll_mv = document.getElementById("right-scroll-mv");
            const left_scroll_album = document.getElementById("left-scroll-album");
            const right_scroll_album = document.getElementById("right-scroll-album");
            const pop_album = document.getElementsByClassName("pop-album")[0];
            const pop_mv = document.getElementsByClassName("pop-mv")[0];
            const playRepeat = document.querySelector(".btn-repeat");
            const randomBtn = document.querySelector(".btn-random");
            const music = new Audio("./assets/music/dunglamtraitimanhdau.flac");
            const nextBtn = document.querySelector(".btn-next");
            const prevBtn = document.querySelector(".btn-prev");
            const durationTime = document.querySelector(".duration");
            const remainingTime = document.querySelector(".remaining");
            const progressBar = document.getElementById("progress");
            const inputField = document.getElementsByClassName('input-field')[0];

            <?php
            $id_album = isset($_GET['id_album']) ? $_GET['id_album'] : null;
            $sql = "SELECT id_song, name_song, author, poster, file, lyrics, id_album FROM song WHERE id_album = '$id_album'";
            $result = $conn->query($sql);

            $songs = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $songs[] = array(
                        'id' => $row['id_song'],
                        'songName' => '<strong>' . $row['name_song'] . '</strong><p>' . $row['author'] . '</p>',
                        'poster' => './assets/img/music/' . $row['poster'],
                        'file' => './assets/music/' . $row['file'],
                        'lyrics' => $row['lyrics']
                    );
                }
            }
            ?>

            const songs = <?php echo json_encode($songs); ?>;
            const lyricsBox = document.querySelector('.lyrics');

            function updateLyrics(index) {
                const lyricsContainer = document.querySelector('.lyrics');
                lyricsContainer.innerHTML = '';
                const lyrics = songs[index - 1].lyrics;
                if (lyrics) {
                    const lyricsLines = lyrics.split('\n');
                    lyricsLines.forEach(line => {
                        const p = document.createElement('p');
                        p.textContent = line;
                        lyricsContainer.appendChild(p);
                    });
                } else {
                    const p = document.createElement('p');
                    p.textContent = 'Không có lời bài hát';
                    lyricsContainer.appendChild(p);
                }
            }

            Array.from(document.getElementsByTagName("tr")).forEach((element, index) => {
                element.addEventListener("click", () => {
                    updateLyrics(index);
                });
            });

            left_scroll_mv.addEventListener("click", () => {
                pop_mv.scrollLeft -= 300;
            });

            right_scroll_mv.addEventListener("click", () => {
                pop_mv.scrollLeft += 300;
            });

            left_scroll_album.addEventListener("click", () => {
                pop_album.scrollLeft -= 300;
            });

            right_scroll_album.addEventListener("click", () => {
                pop_album.scrollLeft += 300;
            });

            Array.from(document.getElementsByClassName("mv-item")).forEach((element, i) => {
                // element.getElementsByTagName("img")[0].src = songs[i].poster;
                element.getElementsByClassName("mv-item-content")[0].innerHTML =
                    songs[i].songName;
            });

            let playMaster = document.getElementById("playMaster");
            playMaster.addEventListener("click", () => {
                if (music.paused || music.currentTime <= 0) {
                    music.play();
                    playMaster.classList.remove("fa-play");
                    playMaster.classList.add("fa-pause");
                } else {
                    music.pause();
                    playMaster.classList.add("fa-play");
                    playMaster.classList.remove("fa-pause");
                }
            });
            nextBtn.addEventListener("click", () => {
                makeAllBackgrounds();
                if (isRandomMode) {
                    playRandomSong();
                } else {
                    currentIndex = (currentIndex + 1) % songs.length;
                    updatePlayer(currentIndex);
                }
                const currentRow = document.getElementsByTagName("tr")[currentIndex];
                currentRow.style.background = "lightgray";
                updateLyrics(currentIndex); // Cập nhật lời bài hát
            });

            prevBtn.addEventListener("click", () => {
                makeAllBackgrounds();
                if (isRandomMode) {
                    playRandomSong();
                } else {
                    currentIndex = (currentIndex - 1 + songs.length) % songs.length;
                    updatePlayer(currentIndex);
                }
                const currentRow = document.getElementsByTagName("tr")[currentIndex];
                currentRow.style.background = "lightgray";
                updateLyrics(currentIndex);
            });


            let isRepeat = false;
            playRepeat.addEventListener("click", function() {
                if (isRepeat) {
                    isRepeat = false;
                    playRepeat.classList.remove("active");
                } else {
                    isRepeat = true;
                    playRepeat.classList.toggle("active");
                }
            });

            const makeAllBackgrounds = () => {
                Array.from(document.getElementsByTagName("tr")).forEach((element) => {
                    element.style.background = "white";
                });
            };

            let currentIndex = 0;
            Array.from(document.getElementsByTagName("tr")).forEach((element, index) => {
                element.addEventListener("click", () => {
                    makeAllBackgrounds();
                    element.style.background = "lightgray";
                    currentIndex = index;
                    updatePlayer(currentIndex);
                    if (music.paused || music.currentTime <= 0) {
                        music.play();
                        playMaster.classList.remove("fa-play");
                        playMaster.classList.add("fa-pause");
                    } else {
                        music.pause();
                        playMaster.classList.add("fa-play");
                        playMaster.classList.remove("fa-pause");
                    }
                });
            });

            Array.from(document.getElementsByClassName("card")).forEach((element, index) => {
                element.addEventListener("click", () => {
                    makeAllBackgrounds();
                    const songName = element.getAttribute('data-songName');
                    const author = element.getAttribute('data-author');
                    const file = element.getAttribute('data-file');
                    const poster = element.getAttribute('data-poster');
                    const lyrics = element.getAttribute('data-lyrics');

                    posterMasterPlay.src = `./assets/img/music/${poster}`;
                    title.innerHTML = `<strong>${songName}</strong><p>${author}</p>`;
                    music.src = `./assets/music/${file}`;
                    const lyricsContainer = document.querySelector('.lyrics');
                    lyricsContainer.innerHTML = '';
                    if (lyrics) {
                        const lyricsLines = lyrics.split('\n');
                        lyricsLines.forEach(line => {
                            const p = document.createElement('p');
                            p.textContent = line;
                            lyricsContainer.appendChild(p);
                        });
                    } else {
                        const p = document.createElement('p');
                        p.textContent = 'Không có lời bài hát';
                        lyricsContainer.appendChild(p);
                    }

                    if (music.paused || music.currentTime <= 0) {
                        music.play();
                        playMaster.classList.remove("fa-play");
                        playMaster.classList.add("fa-pause");
                    } else {
                        music.pause();
                        playMaster.classList.add("fa-play");
                        playMaster.classList.remove("fa-pause");
                    }
                    inputField.value = null;
                    if (inputField.value == 0) {
                        search_result.style.display = "none";
                    } else {
                        search_result.style.display = "flex";
                    }

                });
            });

            let posterMasterPlay = document.getElementById("music-img-img");
            let title = document.getElementById("title");

            function updatePlayer(index) {
                const song = songs[index - 1];
                posterMasterPlay.src = song.poster;
                title.innerHTML = song.songName;
                music.src = song.file;
                const duration = music.duration;
                progressBar.max = duration;
                progressBar.value = 0;
                music.play();
            }
            music.addEventListener("ended", () => {
                if (isRepeat) {
                    updatePlayer(currentIndex);
                } else {
                    makeAllBackgrounds();
                    currentIndex = (currentIndex + 1) % songs.length;
                    updatePlayer(currentIndex);
                    const currentRow = document.getElementsByTagName("tr")[currentIndex];
                    currentRow.style.background = "lightgray";
                    updateLyrics(currentIndex);
                }
            });

            function formatTime(time) {
                let minutes = Math.floor(time / 60);
                let seconds = Math.floor(time % 60);
                return `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
            }

            function updateTimer() {
                const currentTime = music.currentTime;
                const duration = music.duration;
                remainingTime.textContent = formatTime(duration);
                durationTime.textContent = formatTime(currentTime);
            }
            let timerInterval;

            function startTimer() {
                timerInterval = setInterval(updateTimer, 1000);
            }

            function stopTimer() {
                clearInterval(timerInterval);
            }
            music.addEventListener("play", startTimer);
            music.addEventListener("pause", stopTimer);
            music.addEventListener("ended", stopTimer);

            function updateProgress() {
                const currentTime = music.currentTime;
                const duration = music.duration;
                const progress = (currentTime / duration) * 100;
                progressBar.value = progress;
            }
            music.addEventListener("timeupdate", updateProgress);
            progressBar.addEventListener("input", () => {
                const seekTime = (progressBar.value / 100) * music.duration;
                music.currentTime = seekTime;
            });

            let isRandomMode = false;
            randomBtn.addEventListener("click", () => {
                isRandomMode = !isRandomMode;
                randomBtn.classList.toggle("active");

                if (isRandomMode) {
                    music.addEventListener("ended", playRandomSong);
                } else {
                    music.removeEventListener("ended", playRandomSong);
                }
            });

            function playRandomSong() {
                let randomIndex;
                do {
                    randomIndex = Math.floor(Math.random() * songs.length);
                } while (randomIndex === currentIndex);

                makeAllBackgrounds();
                currentIndex = randomIndex;
                updatePlayer(currentIndex);
                const currentRow = document.getElementsByTagName("tr")[currentIndex];
                currentRow.style.background = "lightgray";
            }

            const volumeSlider = document.getElementById('volume-slider');
            const volumeIcon = document.getElementById('volume-icon');

            volumeSlider.value = 50;

            volumeSlider.addEventListener('input', () => {
                music.volume = volumeSlider.value / 100;
                updateVolumeIcon();
            });

            function updateVolumeIcon() {
                const volume = music.volume;
                if (volume === 0) {
                    volumeIcon.classList.remove('fa-volume-high', 'fa-volume-low');
                    volumeIcon.classList.add('fa-volume-mute');
                } else if (volume < 0.5) {
                    volumeIcon.classList.remove('fa-volume-high', 'fa-volume-mute');
                    volumeIcon.classList.add('fa-volume-low');
                } else {
                    volumeIcon.classList.remove('fa-volume-low', 'fa-volume-mute');
                    volumeIcon.classList.add('fa-volume-high');
                }
            }
            updateVolumeIcon();
        </script>

        <div id="videoModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <video id="modalVideo" controls></video>
            </div>
        </div>

        <script>
            var modal = document.getElementById("videoModal");

            var span = document.getElementsByClassName("close")[0];

            var modalVideo = document.getElementById("modalVideo");

            var links = document.querySelectorAll(".btn-mv");
            links.forEach(function(link) {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    var videoSrc = this.getAttribute("data-video");
                    modalVideo.src = videoSrc;
                    modal.style.display = "block";
                    modalVideo.play();
                });
            });

            // nhấn x là thoát
            span.onclick = function() {
                modal.style.display = "none";
                modalVideo.pause();
            }

            // nhấn ngoài là thoát
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    modalVideo.pause();
                }
            }

            modalVideo.addEventListener('play', () => {
                if (!music.paused) {
                    isOutsideMusicPlaying = true;
                    music.pause();
                }
            });

            modalVideo.addEventListener('pause', () => {
                if (isOutsideMusicPlaying) {
                    isOutsideMusicPlaying = false;
                    music.play();
                }
            });
        </script>

</body>

</html>