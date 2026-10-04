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
    result: Interpretation;

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
        this.result = new Interpretation(this.selected);
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
            this.result.show();
            this.showResetBtns();
        }
        this.enableLaunchGameBtns();
    }

    private reset() {
        this.selected.length = 0;
        this.result.reset();
        this.showLaunchGameBtns();
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
            btn.addEventListener('click', () => this.launchGame(), {
                once: true,
            })
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

    private showLaunchGameBtns() {
        this.elements.launchGameBtns.forEach((btn) => {
            const launchGameLabel = btn.getAttribute('data-default-slot');

            if (!launchGameLabel) {
                throw new Error(
                    "The launch game button doesn't have a default slot attribute"
                );
            }
            btn.textContent = launchGameLabel;
        });

        this.launchGameOnClick();
    }

    private showResetBtns() {
        this.elements.launchGameBtns.forEach((btn) => {
            const resetLabel = btn.getAttribute('data-reset-slot');

            if (!resetLabel) {
                throw new Error(
                    "The launch game button doesn't have a reset slot attribute"
                );
            }
            btn.textContent = resetLabel;
            btn.addEventListener('click', () => this.reset(), { once: true });
        });
    }
}
