import { GAME_TYPES } from '../constants';
import { qs, qsa, wait } from '../utils';

type Elements = {
    launchGameBtns: NodeListOf<HTMLButtonElement>;
    setNumRoundsBtns: NodeListOf<HTMLButtonElement>;
    game: HTMLDivElement;
};

export default class Game {
    selected: HTMLElement[];
    numRounds: number;
    elements: Elements;
    gameTypes: Record<string, (arg: HTMLElement) => Promise<HTMLElement>>;

    constructor() {
        this.elements = {
            launchGameBtns: qsa<HTMLButtonElement>('[cmp-launch-game-btn]'),
            setNumRoundsBtns: qsa<HTMLButtonElement>(
                '[cmp-set-num-rounds-btn]'
            ),
            game: qs<HTMLDivElement>('[cmp-game]'),
        };
        this.selected = [];
        this.numRounds = 1;
        this.gameTypes = {
            [GAME_TYPES.RANDOM_CARDS]: this.spinRandomCards,
        };
    }

    public init() {
        this.launchGameOnClick();
        this.setNumRounds();
    }

    private async launchGame() {
        const type = this.elements.game.getAttribute('data-type');

        if (!type) {
            throw new Error("The game doesn't contain the type attribute");
        }

        this.disableLaunchGameBtns();

        const selectedItem = await this.gameTypes[type](this.elements.game);

        this.selected.push(selectedItem);

        if (this.selected.length >= this.numRounds) {
            this.displayResults();
            this.reset();
        }
        this.enableLaunchGameBtns();
    }

    private reset() {
        this.selected.length = 0;
    }


    private setNumRounds() {
        this.elements.setNumRoundsBtns.forEach((btn) =>
            btn.addEventListener('click', () => {
                const numRounds = btn.getAttribute('data-numRounds');

                if (!numRounds) {
                    console.error('No numRounds attribute is set');
                    return;
                }
                const num = Number(numRounds);

                if (isNaN(num)) {
                    console.error('Invalid data attribute format');
                    return;
                }

                this.numRounds = Math.max(5, num);
            })
        );
    }

    private launchGameOnClick() {
        this.elements.launchGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.launchGame())
        );
    }

    private disableLaunchGameBtns() {
        this.elements.launchGameBtns.forEach((btn) =>
            btn.setAttribute('disabled', 'true')
        );
    }

    private enableLaunchGameBtns() {
        this.elements.launchGameBtns.forEach((btn) =>
            btn.removeAttribute('disabled')
        );
    }

    private async spinRandomCards(gameElement: HTMLElement) {
        const cards = qsa<HTMLLIElement>('[cmp-card]', gameElement);

        let duration = 50;
        let currentIdx = 0;

        const handleNext = () => {
            const prevIdx =
                currentIdx === 0 ? cards.length - 1 : currentIdx - 1;
            cards[prevIdx].classList.remove('highlighted');
            cards[currentIdx].classList.add('highlighted');
            currentIdx = currentIdx === cards.length - 1 ? 0 : currentIdx + 1;
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
