import { EVENTS } from '../constants';
import { qs, qsa } from '../utils';

type Elements = {
    revealGameBtns: NodeListOf<HTMLButtonElement>;
    hideGameBtns: NodeListOf<HTMLButtonElement>;
    hideOnClickBtns: NodeListOf<HTMLDivElement>;
    toggleGameInputs: NodeListOf<HTMLInputElement>;
    stage: HTMLDivElement | null;
};

export default class GameStage {
    elements: Elements;

    constructor() {
        this.elements = {
            revealGameBtns: qsa<HTMLButtonElement>('[cmp-reveal-game-btn]'),
            hideGameBtns: qsa<HTMLButtonElement>('[cmp-hide-game-btn]'),
            hideOnClickBtns: qsa<HTMLDivElement>('[cmp-hide-on-click]'),
            toggleGameInputs: qsa<HTMLInputElement>('[cmp-game-toggle]'),
            stage: qs<HTMLDivElement>('[cmp-game-stage]', 'silent'),
        };
    }

    public init() {
        if (!this.elements.stage) return;

        this.elements.revealGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.revealGame(), {
                once: true,
            })
        );
        this.elements.hideGameBtns.forEach((btn) =>
            btn.addEventListener('click', () => this.hideGame())
        );
        this.elements.hideOnClickBtns.forEach((btn) =>
            btn.addEventListener('click', () => btn.remove())
        );
        this.elements.toggleGameInputs.forEach((input) =>
            input.addEventListener('change', () =>
                window.dispatchEvent(new CustomEvent(EVENTS.RESET_GAME))
            )
        );
    }

    private revealGame() {
        if (!this.elements.stage) return;

        this.elements.stage.classList.remove('hidden');
        this.elements.stage.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });
    }

    private hideGame() {
        this.elements.stage?.classList.add('hidden');
    }
}
