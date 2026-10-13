import { qs, qsa, wait } from '../utils';

export default function initAffirmations() {
    const wrapper = qs<HTMLDivElement>('[cmp-aff-wrapper]', 'silent');
    let offset = 0;

    if (!wrapper) return;

    const button = qs<HTMLButtonElement>('[cmp-aff-btn]');
    const quoteContainer = qs<HTMLParagraphElement>('[cmp-aff-quote]');

    async function selectAffirmation() {
        if (!wrapper || !quoteContainer) return;

        quoteContainer.textContent = '';

        const affirmations = qsa<HTMLLIElement>(
            '[cmp-aff-wrapper] li[data-quote]'
        );
        const list = qs<HTMLDivElement>('[cmp-aff-wrapper] [cmp-item-list]');

        let duration = 50;

        const handleNext = async () => {
            offset++;
            const currentIdx = offset % affirmations.length;
            const prevIdx =
                currentIdx === 0 ? affirmations.length - 1 : currentIdx - 1;
            list.style.setProperty('--offset', offset.toString());

            affirmations[prevIdx].classList.remove('highlighted');
            affirmations[currentIdx].classList.add('highlighted');

            await wait(500);
            affirmations[currentIdx].scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });
        };

        let extraDuration = Math.floor(Math.random() * 10) + 5;
        const maxDuration = 400;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        const selected =
            affirmations[(offset + affirmations.length) % affirmations.length];

        const quote = selected.getAttribute('data-quote');

        if (!quote) {
            throw new Error(
                'No data-quote attribute found on the affirmation list item element'
            );
        }

        quoteContainer.textContent = quote;
        button.removeAttribute('disabled');
    }

    button.addEventListener('click', () => {
        const repeatLabel = button.getAttribute('data-repeat-label');

        if (!repeatLabel) {
            throw new Error(
                'No data-repeat-label attribute found on the start affirmation carousel button element'
            );
        }

        button.textContent = repeatLabel;
        button.setAttribute('disabled', 'true');
        selectAffirmation();
    });
}
