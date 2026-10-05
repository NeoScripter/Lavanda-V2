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
    selectedItemsUI: HTMLUListElement | null;
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
            selectedItemsUI: qs<HTMLUListElement>(
                '[cmp-selected-items]',
                'silent'
            ),
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
        this.setState('during');

        const selectedItem = await round.run();

        this.selected.push(selectedItem);
        this.showSelectedItem(selectedItem);

        if (this.selected.length >= this.numRounds) {
            this.setState('end');
            await this.result.show();
        }

        this.enableGameBtns();
    }

    private reset() {
        this.selected.length = 0;

        if (this.elements.selectedItemsUI) {
            this.elements.selectedItemsUI.innerHTML = '';
        }

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
        [
            ...this.elements.visibleAtStart,
            ...this.elements.visibleAtEnd,
            ...this.elements.visibleDuring,
        ].forEach((el) => el.classList.add('hidden'));

        if (type === 'start') {
            this.elements.visibleAtStart.forEach((el) =>
                el.classList.remove('hidden')
            );
        } else if (type === 'end') {
            this.elements.visibleAtEnd.forEach((el) =>
                el.classList.remove('hidden')
            );
        } else {
            this.elements.visibleDuring.forEach((el) =>
                el.classList.remove('hidden')
            );
        }
    }

    private showSelectedItem(item: HTMLLIElement) {
        if (!this.elements.selectedItemsUI) return;

        const frontSrc = item.getAttribute('data-front-img-src');
        const frontAlt = item.getAttribute('data-front-img-alt');
        const backSrc = item.getAttribute('data-back-img-src');
        const backAlt = item.getAttribute('data-back-img-alt');

        if (!backSrc || !backAlt || !frontSrc || !frontAlt) {
            throw new Error(
                "Item element doesn't contain the image data attributes"
            );
        }

        item.innerHTML = item.innerHTML.replaceAll(backSrc, frontSrc);
        item.innerHTML = item.innerHTML.replace(backAlt, frontAlt);

        this.elements.selectedItemsUI.appendChild(item);
    }
}
