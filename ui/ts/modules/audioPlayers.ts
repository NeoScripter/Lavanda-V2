import { qs, qsa } from '../utils';

export default function initAudioPlayers() {
    const players = qsa<HTMLDivElement>('[cmp-audio-player]');

    for (const player of players) {
        const audio = qs<HTMLAudioElement>('audio', 'error', player);
        const playBtn = qs<HTMLButtonElement>(
            '[cmp-play-audio-btn]',
            'error',
            player
        );
        const pauseBtn = qs<HTMLButtonElement>(
            '[cmp-pause-audio-btn]',
            'error',
            player
        );
        const input = qs<HTMLInputElement>(
            'input[type="range"]',
            'error',
            player
        );

        updateProgress(player);
        audio.addEventListener('loadedmetadata', () => updateProgress(player));
        audio.addEventListener('timeupdate', () => updateProgress(player));

        input.addEventListener('change', () => {
            audio.currentTime = Number(input.value);
        })

        playBtn.addEventListener('click', () => {
            if (audio.paused) {
                pauseBtn.classList.remove('hidden');
                playBtn.classList.add('hidden');
                audio.play();
            }
        });
        pauseBtn.addEventListener('click', () => {
            if (!audio.paused) {
                pauseBtn.classList.add('hidden');
                playBtn.classList.remove('hidden');
                audio.pause();
            }
        });
    }

    function updateProgress(player: HTMLDivElement) {
        const audio = qs<HTMLAudioElement>('audio', 'error', player);
        const startTimeSpan = qs<HTMLSpanElement>(
            '[cmp-start-time]',
            'error',
            player
        );
        const endTimeSpan = qs<HTMLSpanElement>(
            '[cmp-end-time]',
            'error',
            player
        );
        const input = qs<HTMLInputElement>(
            'input[type="range"]',
            'error',
            player
        );

        const totalDuration = audio.duration;
        const currentTime = audio.currentTime;

        input.max = totalDuration.toFixed();
        input.value = currentTime.toFixed();

        endTimeSpan.textContent = formatAudioTime(totalDuration);
        startTimeSpan.textContent = formatAudioTime(currentTime);
    }

    function formatAudioTime(totalSeconds: number) {
        const minutes = Math.floor(totalSeconds / 60)
            .toFixed()
            .padStart(2, '0');
        const seconds = (totalSeconds % 60).toFixed().padStart(2, '0');

        return `${minutes}:${seconds}`;
    }
}
