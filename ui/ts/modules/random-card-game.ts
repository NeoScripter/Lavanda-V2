import { EVENTS } from '../constants';
import { qsa, wait } from '../utils';

export default function initRandomCardGame() {
    async function spinCardDeck() {
        const cards = qsa<HTMLLIElement>('[cmp-random-card-game]>*');

        let duration = 50;
        let currentIdx = 0;

        const handleNext = () => {
            const prevIdx =
                currentIdx === 0 ? cards.length - 1 : currentIdx - 1;
            cards[prevIdx].classList.remove('highlighted');
            cards[currentIdx].classList.add('highlighted');
            currentIdx = currentIdx === cards.length - 1 ? 0 : currentIdx + 1;
        };

        const endGame = () => {
            const prevIdx =
                currentIdx === 0 ? cards.length - 1 : currentIdx - 1;
            const card = cards[currentIdx];
            card.classList.remove('highlighted');
            cards[prevIdx].classList.remove('highlighted');

            const event = new CustomEvent(EVENTS.END_SPIN, {
                detail: { card },
            });
            window.dispatchEvent(event);
        };

        let extraDuration = Math.floor(Math.random() * 10);
        const maxDuration = 400;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + 5 + extraDuration);
            await wait(duration);
        }
        endGame();
    }

    window.addEventListener(EVENTS.START_SPIN, spinCardDeck);
}
