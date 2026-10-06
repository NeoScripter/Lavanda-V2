import { ROUND_TYPE, type GameInfo } from '../constants';
import { qsa, wait } from '../utils';

export default class GameRound {

    public run(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return this.randomCards();
            default:
                throw new Error('Unknown game round option');
        }
    }

    private async randomCards() {
        const cards = qsa<HTMLLIElement>('[cmp-game]>li');

        let duration = 50;
        let currentIdx = 0;

        const handleNext = () => {
            const prevIdx =
                currentIdx === 0 ? cards.length - 1 : currentIdx - 1;
            cards[prevIdx].classList.remove('highlighted');
            cards[currentIdx].classList.add('highlighted');
            currentIdx = currentIdx === cards.length - 1 ? 0 : currentIdx + 1;

            cards[currentIdx].scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });
        };

        let extraDuration = Math.floor(Math.random() * 15);
        // const maxDuration = 400;
        const maxDuration = 200;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        cards.forEach((card) => card.classList.remove('highlighted'));
        return cards[currentIdx];
    }
}
