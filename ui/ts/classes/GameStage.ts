import { qs, qsa } from '../utils';

type Elements = {
    revealGameBtns: NodeListOf<HTMLButtonElement>;
    hideGameBtns: NodeListOf<HTMLButtonElement>;
    hideOnClickBtns: NodeListOf<HTMLDivElement>;
    stage: HTMLDivElement;
};

export default class GameStage {
    elements: Elements;

    constructor() {
        this.elements = {
            revealGameBtns: qsa<HTMLButtonElement>('[cmp-reveal-game-btn]'),
            hideGameBtns: qsa<HTMLButtonElement>('[cmp-hide-game-btn]'),
            hideOnClickBtns: qsa<HTMLDivElement>('[cmp-hide-on-click]'),
            stage: qs<HTMLDivElement>('[cmp-game-stage]'),
        };
    }

    public init() {
        this.elements.revealGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.revealGame())
        );
        this.elements.hideGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.hideGame())
        );
        this.elements.hideOnClickBtns.forEach((btn) =>
            btn.addEventListener('click', () => btn.remove())
        );
    }

    private revealGame() {
        this.elements.stage.classList.remove('hidden');
    }

    private hideGame() {
        this.elements.stage.classList.add('hidden');
    }
}
