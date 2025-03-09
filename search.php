<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngot_database";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
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
    <link rel="stylesheet" href="assets/css/search.css" />
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
                    <div class="search-bar">
                        <input type="text" placeholder="Bạn cần tìm gì?" class="input-field" />
                        <i class="icon fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h1 class="title">Kết quả tìm thấy</h1>
                    <div id="song">
                        <div class="section-header">
                            <h1 class="section-title">Song</h1>
                            <div class="btn-scroll">
                                <i id="left-scroll-song" class="fa fa-arrow-left" aria-hidden="true"></i>
                                <i id="right-scroll-song" class="fa fa-arrow-right" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="pop-song"></div>
                    </div>
                    <div id="album">
                        <div class="section-header">
                            <h1 class="section-title">Album</h1>
                            <div class="btn-scroll">
                                <i id="left-scroll-album" class="fa fa-arrow-left" aria-hidden="true"></i>
                                <i id="right-scroll-album" class="fa fa-arrow-right" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="pop-album"></div>
                    </div>
                    <div id="mv">
                        <div class="section-header">
                            <h1 class="section-title">MV</h1>
                            <div class="btn-scroll">
                                <i id="left-scroll-mv" class="fa fa-arrow-left" aria-hidden="true"></i>
                                <i id="right-scroll-mv" class="fa fa-arrow-right" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="pop-mv"></div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="footer-content">
                    <div class="footer-info">
                        <p>Địa chỉ: Hà Nội.</p>
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

    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <video id="modalVideo" controls></video>
        </div>
    </div>

    <script>
        <?php
        $sql_mv = "SELECT * FROM mv";
        $sql_song = "SELECT * FROM song WHERE id_album != 'hit' AND id_album != 'trending' AND id_album != 'newin' AND id_album != '1'";
        $sql_album = "SELECT * FROM album WHERE type = 'album' or type = 'single'";

        $mv = array();
        $song = array();
        $album = array();

        $result_mv = $conn->query($sql_mv);
        $result_song = $conn->query($sql_song);
        $result_album = $conn->query($sql_album);

        if ($result_mv->num_rows > 0) {
            while ($row = $result_mv->fetch_assoc()) {
                $mv[] = array(
                    'id_mv' => $row['id_mv'],
                    'name_mv' => $row['name_mv'],
                    'img_mv' => $row['img_mv'],
                    'file' => $row['file']
                );
            }
        }

        if ($result_song->num_rows > 0) {
            while ($row = $result_song->fetch_assoc()) {
                $song[] = array(
                    'id_song' => $row["id_song"],
                    'name_song' => $row["name_song"],
                    'author' => $row["author"],
                    'poster' => $row["poster"],
                    'file' => $row["file"],
                    'lyrics' => $row["lyrics"],
                    'time' => $row["time"],
                    'id_album' => $row["id_album"]
                );
            }
        }

        if ($result_album->num_rows > 0) {
            while ($row = $result_album->fetch_assoc()) {
                $album[] = array(
                    'id_album' => $row["id_album"],
                    'name_album' => $row["name_album"],
                    'img_album' => $row["img_album"],
                    'author' => $row["author"],
                    'sl_song' => $row["sl_song"],
                    'year' => $row["year"]
                );
            }
        }
        ?>

        let mv = <?php echo json_encode($mv); ?>;
        let song = <?php echo json_encode($song); ?>;
        let album = <?php echo json_encode($album); ?>;

        let pop_mv = document.getElementsByClassName('pop-mv')[0];
        let pop_song = document.getElementsByClassName('pop-song')[0];
        let pop_album = document.getElementsByClassName('pop-album')[0];

        mv.forEach(element => {
            const {
                id_mv,
                name_mv,
                img_mv,
                file
            } = element;
            let card = document.createElement('a');
            card.classList.add('mv-item');
            card.dataset.video = `./assets/video/video_music/${file}`;
            card.innerHTML = `
            <img src="./assets/img/mv/${img_mv}" alt="img" />
            <h3 class="mv-key">${name_mv}</h3>
        `;
            pop_mv.appendChild(card);
        })

        song.forEach(element => {
            const {
                id_song,
                name_song,
                author,
                poster,
                file,
                lyrics,
                time,
                id_album
            } = element;
            let card = document.createElement('a');
            card.classList.add('song-item');
            card.setAttribute('name_song', name_song);
            card.setAttribute('poster', poster);
            card.setAttribute('author', author);
            card.setAttribute('file', file);
            card.setAttribute('lyrics', lyrics);
            card.setAttribute('id_album', id_album);
            card.innerHTML = `
            <img src="./assets/img/music/${poster}" alt="img" />
            <div class="song-item-title">
                <h1 class="song-key">${name_song}</h1>
                <p>${time}</p>
            </div>
            <p class="song-item-author">${author}</p>
        `;
            pop_song.appendChild(card);
        })

        album.forEach(element => {
            const {
                id_album,
                name_album,
                img_album,
                author,
                sl_song,
                year
            } = element;
            let card = document.createElement('a');
            card.href = `music.php?id_album=${id_album}`;
            card.classList.add('album-item');
            card.innerHTML = `
            <img src="./assets/img/music/${img_album}" alt="img" />
            <div class="album-item-title">
                <h1 class="album-key">${name_album}</h1>
                <p>${year}</p>
            </div>
            <p class="album-item-author">${author}</p>
            <p class="album-item-songs">${sl_song} Bài hát</p>
        `;
            pop_album.appendChild(card);
        });

        let input = document.getElementsByTagName('input')[0];
        input.addEventListener('keyup', () => {
            let input_value = input.value;
            let mv_item = pop_mv.getElementsByTagName('a');
            let song_item = pop_song.getElementsByTagName('a');
            let album_item = pop_album.getElementsByTagName('a');

            for (let i = 0; i < mv_item.length; i++) {
                let as = mv_item[i].getElementsByClassName('mv-key')[0];
                let text_value = as.textContent || as.innerText;

                if (text_value.toUpperCase().indexOf(input_value.toUpperCase()) > -1) {
                    mv_item[i].style.display = "flex";
                } else {
                    mv_item[i].style.display = "none";
                }
            }

            for (let i = 0; i < song_item.length; i++) {
                let as = song_item[i].getElementsByClassName('song-key')[0];
                let text_value = as.textContent || as.innerText;

                if (text_value.toUpperCase().indexOf(input_value.toUpperCase()) > -1) {
                    song_item[i].style.display = "flex";
                } else {
                    song_item[i].style.display = "none";
                }
            }

            for (let i = 0; i < album_item.length; i++) {
                let as = album_item[i].getElementsByClassName('album-key')[0];
                let text_value = as.textContent || as.innerText;

                if (text_value.toUpperCase().indexOf(input_value.toUpperCase()) > -1) {
                    album_item[i].style.display = "flex";
                } else {
                    album_item[i].style.display = "none";
                }
            }

            if (input_value == 0) {
                pop_mv.style.display = "none";
                pop_song.style.display = "none";
                pop_album.style.display = "none";
            } else {
                pop_mv.style.display = "flex";
                pop_song.style.display = "flex";
                pop_album.style.display = "flex";
            }
        });

        const left_scroll_mv = document.getElementById("left-scroll-mv");
        const right_scroll_mv = document.getElementById("right-scroll-mv");
        const left_scroll_song = document.getElementById("left-scroll-song");
        const right_scroll_song = document.getElementById("right-scroll-song");
        const left_scroll_album = document.getElementById("left-scroll-album");
        const right_scroll_album = document.getElementById("right-scroll-album");

        left_scroll_mv.addEventListener("click", () => {
            pop_mv.scrollLeft -= 300;
        });

        right_scroll_mv.addEventListener("click", () => {
            pop_mv.scrollLeft += 300;
        });

        left_scroll_song.addEventListener("click", () => {
            pop_song.scrollLeft -= 300;
        });

        right_scroll_song.addEventListener("click", () => {
            pop_song.scrollLeft += 300;
        });

        left_scroll_album.addEventListener("click", () => {
            pop_album.scrollLeft -= 300;
        });

        right_scroll_album.addEventListener("click", () => {
            pop_album.scrollLeft += 300;
        });

        //
        //
        //  Music player
        //
        //

        const playRepeat = document.querySelector(".btn-repeat");
        const randomBtn = document.querySelector(".btn-random");
        const music = new Audio("./assets/music/dunglamtraitimanhdau.flac");
        const nextBtn = document.querySelector(".btn-next");
        const prevBtn = document.querySelector(".btn-prev");
        const durationTime = document.querySelector(".duration");
        const remainingTime = document.querySelector(".remaining");
        const progressBar = document.getElementById("progress");
        const posterMasterPlay = document.getElementById("music-img-img");
        const playMaster = document.getElementById("playMaster");

        Array.from(document.getElementsByClassName("song-item")).forEach((element, index) => {
            element.addEventListener("click", () => {
                const songName = element.getAttribute('name_song');
                const author = element.getAttribute('author');
                const file = element.getAttribute('file');
                const poster = element.getAttribute('poster');
                const lyrics = element.getAttribute('lyrics');

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
            })
        })

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

        let isRepeat = false;
        playRepeat.addEventListener("click", function() {
            isRepeat = !isRepeat;
            playRepeat.classList.toggle("active");
        });

        music.addEventListener("ended", () => {
            if (isRepeat) {
                music.currentTime = 0;
                music.play();
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
        updateVolumeIcon();
    </script>

    <script>
        var modal = document.getElementById("videoModal");
        var span = document.getElementsByClassName("close")[0];
        var modalVideo = document.getElementById("modalVideo");
        var isOutsideMusicPlaying = false;

        var links = document.querySelectorAll(".mv-item");
        links.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var videoSrc = this.dataset.video;
                modalVideo.src = videoSrc;
                modal.style.display = "block";
                modalVideo.play();
            });
        });

        span.onclick = function() {
            modal.style.display = "none";
            modalVideo.pause();
        }

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