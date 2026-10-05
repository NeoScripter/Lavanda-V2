import { qs, qsa } from '../utils';
import GameRound from './GameRound';
import Interpretation from './Interpretation';

type Elements = {
    launchGameBtns: NodeListOf<HTMLButtonElement>;
    resetGameBtns: NodeListOf<HTMLButtonElement>;
    visibleAtStart: NodeListOf<HTMLElement>;
    visibleAtEnd: NodeListOf<HTMLElement>;
    visibleDuring: NodeListOf<HTMLElement>;
    setNumRoundsBtns: NodeListOf<HTMLButtonElement>;
    game: HTMLDivElement;
};

export default class Game {
    selected: HTMLElement[];
    numRounds: number;
    elements: Elements;
    result: Interpretation;

    constructor() {
        this.elements = {
            game: qs<HTMLDivElement>('[cmp-game]'),
            launchGameBtns: qsa<HTMLButtonElement>('[cmp-launch-game-btn]'),
            resetGameBtns: qsa<HTMLButtonElement>('[cmp-reset-game-btn]'),
            setNumRoundsBtns: qsa<HTMLButtonElement>(
                '[cmp-set-num-rounds-btn]'
            ),
            visibleAtStart: qsa<HTMLElement>('[cmp-visible-at-start]'),
            visibleAtEnd: qsa<HTMLElement>('[cmp-visible-at-end]'),
            visibleDuring: qsa<HTMLElement>('[cmp-visible-during]'),
        };
        this.selected = [];
        this.numRounds = 1;
        this.result = new Interpretation(this.selected);
    }

    public init() {
        this.launchGameOnClick();
        this.resetGameOnClick();
        this.setNumRounds();
    }

    private async launchGame() {
        const round = new GameRound();

        this.disableGameBtns();

        const selectedItem = await round.run();

        this.selected.push(selectedItem);

        if (this.selected.length >= this.numRounds) {
            await this.result.show();
            this.setState('end');
        } else {
            this.setState('during');
        }

        this.enableGameBtns();
    }

    private reset() {
        this.selected.length = 0;
        this.result.reset();
        this.setState('start');
        this.elements.game.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });
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

    private resetGameOnClick() {
        this.elements.resetGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.reset())
        );
    }

    private disableGameBtns() {
        [
            ...this.elements.launchGameBtns,
            ...this.elements.visibleAtStart,
            ...this.elements.visibleAtEnd,
            ...this.elements.visibleDuring,
        ].forEach((btn) => btn.setAttribute('disabled', 'true'));
    }

    private enableGameBtns() {
        [
            ...this.elements.launchGameBtns,
            ...this.elements.visibleAtStart,
            ...this.elements.visibleAtEnd,
            ...this.elements.visibleDuring,
        ].forEach((btn) => btn.removeAttribute('disabled'));
    }

    private setState(type: 'start' | 'during' | 'end') {
        this.elements.visibleAtStart.forEach((element) =>
            type === 'start'
                ? element.classList.remove('hidden')
                : element.classList.add('hidden')
        );
        this.elements.visibleDuring.forEach((element) =>
            type === 'during'
                ? element.classList.remove('hidden')
                : element.classList.add('hidden')
        );
        this.elements.visibleAtEnd.forEach((element) =>
            type === 'end'
                ? element.classList.remove('hidden')
                : element.classList.add('hidden')
        );
    }
}
