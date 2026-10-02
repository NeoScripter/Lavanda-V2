import { EVENTS } from '../constants';
import { qsa } from '../utils';

export default function initGameHanlders() {
    const hideAfterClickBtns = qsa<HTMLButtonElement>('[cmp-hide-on-click]');

    hideAfterClickBtns.forEach((btn) =>
        btn.addEventListener('click', () => btn.remove())
    );

    const initGameBtns = qsa<HTMLButtonElement>('[cmp-setup-game-btn]');

    initGameBtns.forEach((btn) =>
        btn.addEventListener('click', () =>
            window.dispatchEvent(new CustomEvent(EVENTS.SETUP_GAME))
        )
    );

    const triggers = qsa<HTMLButtonElement>('[cmp-game-trigger]');

    const disableTriggers = () => {
        triggers.forEach((btn) => btn.setAttribute('disabled', 'true'));
    };
    const enableTriggers = () => {
        triggers.forEach((btn) => btn.removeAttribute('disabled'));
    };

    function setupTriggers() {
        const playgrounds = qsa<HTMLButtonElement>('[cmp-playground-wrapper]');

        playgrounds.forEach((playground) =>
            playground.classList.remove('hidden')
        );

        const handler = () =>
            window.dispatchEvent(new CustomEvent(EVENTS.START_SPIN));

        triggers.forEach((btn) => {
            btn.removeEventListener('click', handler);
            btn.addEventListener('click', handler);
        });
    }

    window.addEventListener(EVENTS.START_SPIN, disableTriggers);
    window.addEventListener(EVENTS.END_SPIN, enableTriggers);
    window.addEventListener(EVENTS.SETUP_GAME, setupTriggers);
}
