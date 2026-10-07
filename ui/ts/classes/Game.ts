import {
    EVENTS,
    GAME_CATEGORY_MAP,
    HTML_TYPE_MAP,
    PICKER_TYPE_MAP,
    ROUND_TYPE_MAP,
    type CategoryType,
    type GameInfo,
} from '../constants';
import { qs, qsa } from '../utils';
import GameRound from './GameRound';
import Interpretation from './Interpretation';
import ItemPicker from './ItemPicker';

type Elements = {
    game: HTMLElement;
    launchGameBtns: NodeListOf<HTMLButtonElement>;
    resetGameBtns: NodeListOf<HTMLButtonElement>;
    visibleAtStart: NodeListOf<HTMLElement>;
    visibleAtEnd: NodeListOf<HTMLElement>;
    visibleDuring: NodeListOf<HTMLElement>;
    setNumRoundsBtns: NodeListOf<HTMLButtonElement>;
    pickableItems: NodeListOf<HTMLButtonElement>;
    selectedItemsUI: HTMLUListElement | null;
    container: HTMLElement;
};

export default class Game {
    selected: HTMLElement[];
    numRounds: number;
    elements: Elements;
    inter: Interpretation;
    info: GameInfo;

    constructor(container: HTMLElement, inter: Interpretation) {
        this.elements = {
            launchGameBtns: qsa<HTMLButtonElement>(
                '[cmp-launch-game-btn]',
                container
            ),
            resetGameBtns: qsa<HTMLButtonElement>(
                '[cmp-reset-game-btn]',
                container
            ),
            setNumRoundsBtns: qsa<HTMLButtonElement>('[data-num-rounds]'),
            visibleAtStart: qsa<HTMLElement>(
                '[cmp-visible-at-start]',
                container
            ),
            visibleAtEnd: qsa<HTMLElement>('[cmp-visible-at-end]', container),
            visibleDuring: qsa<HTMLElement>('[cmp-visible-during]', container),
            pickableItems: qsa<HTMLButtonElement>(
                '[cmp-pickable-item]',
                container
            ),
            game: qs<HTMLElement>('[cmp-game]', 'error', container),
            selectedItemsUI: qs<HTMLUListElement>(
                '[cmp-selected-items]',
                'silent',
                container
            ),
            container,
        };
        this.selected = [];
        this.numRounds = 1;
        this.inter = inter;
        this.info = this.getInfo();
    }

    public init() {
        this.launchGameOnClick();
        this.resetGameOnClick();
        this.setNumRounds();
        this.selectItemOnClick();
    }

    private async launchGame() {
        const round = new GameRound();

        this.disableGameBtns();
        this.setState('during');

        const selectedItems = await round.run(this.info);

        this.selected.push(...selectedItems);

        selectedItems.forEach((item) => this.showSelectedItem(item));

        if (this.selected.length >= this.numRounds) {
            this.setState('end');
            await this.inter.show(this.selected, this.info);
        }

        this.enableGameBtns();
    }

    private handleItemSelect(selectedItem: HTMLElement) {
        this.setState('during');
        this.selected.push(selectedItem);
        this.showSelectedItem(selectedItem.cloneNode(true) as HTMLElement);

        if (this.selected.length >= this.numRounds) {
            this.setState('end');
            this.inter.show(this.selected, this.info);
        }
    }

    private reset() {
        this.selected.forEach((item) =>
            new ItemPicker().cleanup(item, this.info)
        );
        this.selected.length = 0;

        new GameRound().cleanup(this.info);
        if (this.elements.selectedItemsUI) {
            this.elements.selectedItemsUI.innerHTML = '';
        }

        this.inter.reset();
        this.setState('start');

        this.elements.container.scrollIntoView({
            block: 'start',
            behavior: 'smooth',
        });
    }

    private setNumRounds() {
        this.elements.setNumRoundsBtns.forEach((btn) =>
            btn.addEventListener('click', () => {
                const numRounds = btn.getAttribute('data-num-rounds');

                this.elements.setNumRoundsBtns.forEach((btn) =>
                    btn.removeAttribute('aria-selected')
                );
                btn.setAttribute('aria-selected', 'true');

                if (!numRounds) {
                    console.error('Attribute data-num-rounds is not set');
                    return;
                }
                let num = Math.max(Number(numRounds), 0);

                if (isNaN(num)) {
                    console.error('Invalid data attribute format');
                    return;
                }

                this.reset();
                this.numRounds = Math.min(5, num);
            })
        );
    }

    private selectItemOnClick() {
        const picker = new ItemPicker();

        this.elements.pickableItems.forEach((btn) =>
            btn.addEventListener('click', () => {
                const item = picker.select(btn, this.info);

                this.handleItemSelect(item);
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

        window.addEventListener(EVENTS.RESET_GAME, () => this.reset());
    }

    private disableGameBtns() {
        this.elements.launchGameBtns.forEach((btn) =>
            btn.setAttribute('disabled', 'true')
        );
        this.elements.setNumRoundsBtns.forEach((btn) =>
            btn.classList.add('pointer-events-none')
        );
    }

    private enableGameBtns() {
        this.elements.launchGameBtns.forEach((btn) =>
            btn.removeAttribute('disabled')
        );
        this.elements.setNumRoundsBtns.forEach((btn) =>
            btn.classList.remove('pointer-events-none')
        );
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

    private getInfo() {
        const type = this.elements.game.getAttribute('cmp-game');

        if (!type) {
            throw new Error(
                'There is not cmp-game attribute on the game element'
            );
        }

        const key = type as keyof CategoryType;

        const info: GameInfo = {
            html: HTML_TYPE_MAP[key],
            category: GAME_CATEGORY_MAP[key],
            round: ROUND_TYPE_MAP[key],
            picker: PICKER_TYPE_MAP[key],
        };

        return info;
    }

    private showSelectedItem(item: HTMLElement) {
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

        const pickableBtn = item.querySelector('[cmp-pickable-item]');

        if (pickableBtn) {
            pickableBtn.remove();
        }
        const picker = new ItemPicker();
        picker.cleanup(item, this.info);

        this.elements.selectedItemsUI.appendChild(item);
    }
}
