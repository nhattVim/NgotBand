const musicSources = [
    './assets/music/nghethu1.mp3',
    './assets/music/nghethu2.mp3',
    './assets/music/nghethu3.mp3',
    './assets/music/nghethu4.mp3'
];

const allMusic = musicSources.map(src => new Audio(src));
const allIcons = ['icon1', 'icon2', 'icon3', 'icon4'];
const allButtons = ['playMusic1', 'playMusic2', 'playMusic3', 'playMusic4'];

const pauseAllMusic = () => {
    allMusic.forEach((music, index) => {
        music.pause();
        music.currentTime = 0;
        const icon = document.getElementById(allIcons[index]);
        icon.classList.add('fa-circle-play');
        icon.classList.remove('fa-circle-pause');
    });
};

allMusic.forEach((music, index) => {
    const buttonId = allButtons[index];
    const iconId = allIcons[index];

    document.getElementById(buttonId).addEventListener('click', () => {
        if (music.paused || music.currentTime <= 0) {
            pauseAllMusic();
            music.play();
            const icon = document.getElementById(iconId);
            icon.classList.remove('fa-circle-play');
            icon.classList.add('fa-circle-pause');
        } else {
            music.pause();
            const icon = document.getElementById(iconId);
            icon.classList.add('fa-circle-play');
            icon.classList.remove('fa-circle-pause');
        }
    });

    music.addEventListener('ended', () => {
        const icon = document.getElementById(iconId);
        icon.classList.add('fa-circle-play');
        icon.classList.remove('fa-circle-pause');
    });
});
