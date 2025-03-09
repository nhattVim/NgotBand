<?php
$sql_songs = "SELECT id_song, name_song, author, poster, file, lyrics, id_album FROM song WHERE id_album != 'hit' AND id_album != 'trending' AND id_album != 'newin' AND id_album != '1'";
$result_songs = $conn->query($sql_songs);
$search_songs = array();
if ($result_songs->num_rows > 0) {
    while ($row_songs = $result_songs->fetch_assoc()) {
        $search_songs[] = array(
            'id_songs' => $row_songs["id_song"],
            'name_songs' => $row_songs["name_song"],
            'author' => $row_songs["author"],
            'poster' => $row_songs["poster"],
            'file' => $row_songs["file"],
            'lyrics' => $row_songs["lyrics"]
        );
    }
}
?>

<script>
    let search_songs = <?php echo json_encode($search_songs); ?>;
    let search_result = document.getElementsByClassName('search-result')[0];

    search_songs.forEach(element => {
        const {
            id_songs,
            name_songs,
            author,
            poster,
            file,
            lyrics
        } = element;
        let card = document.createElement('a');
        card.classList.add('card');
        card.setAttribute('data-songName', name_songs);
        card.setAttribute('data-author', author);
        card.setAttribute('data-file', file);
        card.setAttribute('data-poster', poster);
        card.setAttribute('data-lyrics', lyrics);
        card.innerHTML = `
            <img src="./assets/img/music/${poster}" alt="img" />
            <div class="search-content">
                <div class="search-content-title">
                    ${name_songs}
                </div>
                <div class="search-content-info">
                    ${author}
                </div>
            </div>
        `;
        search_result.appendChild(card);
    });

    let input = document.getElementsByTagName('input')[0];
    input.addEventListener('keyup', () => {
        let input_value = input.value.toUpperCase();
        let items = search_result.getElementsByTagName('a');

        for (let i = 0; i < items.length; i++) {
            let as = items[i].getElementsByClassName('search-content-title')[0];
            let text_value = as.textContent || as.innerText;

            if (text_value.toUpperCase().indexOf(input_value) > -1) {
                items[i].style.display = "flex";
            } else {
                items[i].style.display = "none";
            }
        }

        if (input.value == 0) {
            search_result.style.display = "none";
        } else {
            search_result.style.display = "flex";
        }
    });
</script>
