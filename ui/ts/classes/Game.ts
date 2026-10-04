import { qs, qsa } from '../utils';
import GameRound from './GameRound';
import Interpretation from './Interpretation';

type Elements = {
    launchGameBtns: NodeListOf<HTMLButtonElement>;
    setNumRoundsBtns: NodeListOf<HTMLButtonElement>;
    game: HTMLDivElement;
};

export default class Game {
    selected: HTMLElement[];
    numRounds: number;
    elements: Elements;

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
    }

    public init() {
        this.launchGameOnClick();
        this.setNumRounds();
    }

    private async launchGame() {
        const round = new GameRound();

        this.disableLaunchGameBtns();

        const selectedItem = await round.run();

        this.selected.push(selectedItem);

        if (this.selected.length >= this.numRounds) {
            const result = new Interpretation(this.selected);
            result.show();
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
}
