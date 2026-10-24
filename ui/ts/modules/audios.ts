import { qs, qsa, wait } from '../utils';

export default function initAudios() {
    const wrapper = qs<HTMLDivElement>('[cmp-audio-wrapper]', 'silent');
    let offset = 0;

    if (!wrapper) return;

    const button = qs<HTMLButtonElement>('[cmp-audio-btn]', 'error');
    const excerpt = qs<HTMLParagraphElement>(
        '[cmp-audio-description]',
        'error',
        wrapper
    );
    const playerWrapper = qs<HTMLAudioElement>(
        '[cmp-audio-player]',
        'error',
        wrapper
    );
    const player = qs<HTMLAudioElement>(
        '[cmp-audio-player] audio',
        'error',
        wrapper
    );
    const figcaption = qs<HTMLSpanElement>(
        '[cmp-audio-player] figcaption',
        'error',
        wrapper
    );

    async function selectAudio() {
        if (!wrapper) return;

        excerpt.textContent = '';

        const audios = qsa<HTMLLIElement>(
            '[cmp-audio-wrapper] li[data-description]'
        );
        const list = qs<HTMLDivElement>('[cmp-audio-wrapper] [cmp-item-list]');

        let duration = 50;

        const handleNext = async () => {
            offset++;
            const currentIdx = offset % audios.length;
            const prevIdx =
                currentIdx === 0 ? audios.length - 1 : currentIdx - 1;
            list.style.setProperty('--offset', offset.toString());

            audios[prevIdx].classList.remove('highlighted');
            audios[currentIdx].classList.add('highlighted');

            await wait(500);
            audios[currentIdx].scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });
        };

        let extraDuration = Math.floor(Math.random() * 10) + 5;
        const maxDuration = 300;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        const currentIdx = (offset + audios.length) % audios.length;
        const prevIdx = currentIdx === 0 ? audios.length - 1 : currentIdx - 1;

        audios[prevIdx].classList.remove('highlighted');
        audios[currentIdx].classList.add('highlighted');
        const selected = audios[currentIdx];

        const description = selected.getAttribute('data-description');
        const audioLink = selected.getAttribute('data-file');

        if (!description) {
            throw new Error(
                'No data-description attribute found on the audioirmation list item element'
            );
        }
        if (!audioLink) {
            throw new Error(
                'No data-file attribute found on the audioirmation list item element'
            );
        }

        excerpt.textContent = description;
        figcaption.textContent = description;
        player.setAttribute('src', audioLink);
        playerWrapper.classList.remove('hidden');
        button.removeAttribute('disabled');
    }

    button.addEventListener('click', () => {
        const repeatLabel = button.getAttribute('data-repeat-label');

        if (!repeatLabel) {
            throw new Error(
                'No data-repeat-label attribute found on the start audioirmation carousel button element'
            );
        }

        player.pause();
        player.pause();
        playerWrapper.classList.add('hidden');
        button.textContent = repeatLabel;
        button.setAttribute('disabled', 'true');
        selectAudio();
    });
}
