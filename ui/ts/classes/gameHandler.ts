import { GAME_TYPES } from '../constants';
import { qs, qsa, wait } from '../utils';

export default class GameHander {
    selected: HTMLElement[];
    limit: number;
    elements: Record<string, HTMLElement>;
    lists: Record<string, NodeListOf<HTMLElement>>;
    gameMap: Record<string, (arg: HTMLElement) => Promise<HTMLElement>>;

    constructor() {
        this.selected = [];
        this.limit = 1;
        this.elements = {};
        this.lists = {};
        this.gameMap = {
            [GAME_TYPES.RANDOM_CARDS]: this.spinRandomCards,
        };
    }

    public init() {
        this.selectElements();
        this.setupHanlders();
    }

    private setupHanlders() {
        this.hideBtnsOnClick();
        this.showGamesOnClick();
        this.startSpinOnClick();
        this.setItemLimit();
    }

    private selectElements() {
        this.lists.revealGameBtns = qsa<HTMLButtonElement>(
            '[cmp-reveal-game-btn]'
        );
        this.lists.hideOnClickBtns = qsa<HTMLDivElement>('[cmp-hide-on-click]');
        this.lists.startSpinBtns = qsa<HTMLButtonElement>(
            '[cmp-start-spin-btn]'
        );
        this.lists.setLimitBtns = qsa<HTMLButtonElement>('[cmp-set-limit-btn]');
        this.elements.playground = qs<HTMLDivElement>(
            '[cmp-playground-wrapper]'
        );
        this.elements.game = qs<HTMLUListElement>(
            '[cmp-game]',
            'error',
            this.elements.playground
        );
        this.elements.gameResults = qs<HTMLDivElement>(
            '[cmp-game-results]',
            'error',
            this.elements.playground
        );
    }

    private async handleSpin() {
        const type = this.elements.game.getAttribute('data-type');

        if (!type) {
            throw new Error("The game doesn't contain the type attribute");
        }

        this.disableStartSpinBtns();

        const selectedItem = await this.gameMap[type](this.elements.game);

        this.selected.push(selectedItem);

        if (this.selected.length >= this.limit) {
            this.displayResults();
            this.reset();
        }
        this.enableStartSpinBtns();
    }

    private reset() {
        this.selected.length = 0;
    }

    private async fetchResults() {
        const ids = this.selected.map((item) => {
            const id = item.getAttribute('data-id');

            if (!id) {
                throw new Error("item doesn't have an id");
            }

            return id;
        });

        const API_URL = '/api/game';
        const queryParams = {
            ids: ids.join(','),
            resource: 'bonus'
        };
        try {
            const queryString = new URLSearchParams(queryParams).toString();
            const url = `${API_URL}?${queryString}`;

            const response = await fetch(url);
            const data = await response.json();
            console.log(data);
        } catch (error) {
            console.log(error);
        }
    }
    private displayResults() {
        this.fetchResults();
        // this.elements.playground.classList.remove('hidden');
    }

    private revealGame() {
        this.elements.playground.classList.remove('hidden');
    }

    private setItemLimit() {
        this.lists.setLimitBtns.forEach((btn) =>
            btn.addEventListener('click', () => {
                const limit = btn.getAttribute('data-limit');

                if (!limit) {
                    console.error('No limit attribute is set');
                    return;
                }
                const num = Number(limit);

                if (isNaN(num)) {
                    console.error('Invalid data attribute format');
                    return;
                }

                this.limit = Math.max(5, num);
            })
        );
    }

    private hideGame() {
        this.elements.playground.classList.add('hidden');
    }

    private startSpinOnClick() {
        this.lists.startSpinBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.handleSpin())
        );
    }
    private showGamesOnClick() {
        this.lists.revealGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.revealGame())
        );
    }
    private hideBtnsOnClick() {
        this.lists.hideOnClickBtns.forEach((btn) =>
            btn.addEventListener('click', () => btn.remove())
        );
    }

    private disableStartSpinBtns() {
        const btns = this.lists.startSpinBtns as NodeListOf<HTMLElement>;
        btns.forEach((btn) => btn.setAttribute('disabled', 'true'));
    }

    private enableStartSpinBtns() {
        const btns = this.lists.startSpinBtns as NodeListOf<HTMLElement>;
        btns.forEach((btn) => btn.removeAttribute('disabled'));
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
