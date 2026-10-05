import { qsa, selectFirstVisibleElement, wait } from '../utils';

type Elements = {
    game: HTMLDivElement;
};

const ROUND_TYPE = {
    RANDOM_CARDS: 'random_cards',
};

const GAME_TYPE_MAP = {
    bonus: ROUND_TYPE.RANDOM_CARDS,
    bonus_home: ROUND_TYPE.RANDOM_CARDS,
};

type GameType = typeof GAME_TYPE_MAP;

export default class GameRound {
    type: GameType[keyof GameType];
    elements: Elements;

    constructor() {
        this.elements = {
            game: selectFirstVisibleElement<HTMLDivElement>('[cmp-game]'),
        };
        this.type = this.getType();
    }

    private getType() {
        const type = this.elements.game.getAttribute('cmp-game');

        if (!type) {
            throw new Error("The game doesn't contain the cmp-game attribute");
        }

        if (!Object.keys(GAME_TYPE_MAP).includes(type)) {
            throw new Error('The game type is invalid');
        }

        const key = type as keyof GameType;
        return GAME_TYPE_MAP[key];
    }

    public run() {
        switch (this.type) {
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

        let extraDuration = Math.floor(Math.random() * 10);
        const maxDuration = 100;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + 5 + extraDuration);
            await wait(duration);
        }

        cards.forEach((card) => card.classList.remove('highlighted'));
        return cards[currentIdx];
    }
}
