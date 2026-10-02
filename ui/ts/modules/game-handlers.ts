import { EVENTS } from '../constants';
import { qsa } from '../utils';

export default function initGameHanlders() {
    qsa<HTMLButtonElement>('[cmp-hide-on-click]').forEach((btn) =>
        btn.addEventListener('click', () => btn.classList.add('hidden'))
    );
    qsa<HTMLButtonElement>('[cmp-setup-game-btn]').forEach((btn) =>
        btn.addEventListener('click', () =>
            window.dispatchEvent(new CustomEvent(EVENTS.SETUP_GAME))
        )
    );
    const disableGameTriggers = () => {
        qsa<HTMLButtonElement>('[cmp-game-trigger]').forEach((btn) =>
            btn.setAttribute('disabled', 'true')
        );
    };
    const enableGameTriggers = () => {
        qsa<HTMLButtonElement>('[cmp-game-trigger]').forEach((btn) =>
            btn.removeAttribute('disabled')
        );
    };
    function setupTriggers() {
        const triggers = qsa<HTMLButtonElement>('[cmp-game-trigger]');
        const playgrounds = qsa<HTMLButtonElement>('[cmp-playground-wrapper]');

        const handler = () =>
            window.dispatchEvent(new CustomEvent(EVENTS.START_SPIN));

        for (const btn of triggers) {
            btn.removeEventListener('click', handler);
            btn.addEventListener('click', handler);
        }

        playgrounds.forEach((playground) =>
            playground.classList.remove('hidden')
        );
    }

    window.addEventListener(EVENTS.START_SPIN, disableGameTriggers);
    window.addEventListener(EVENTS.END_SPIN, enableGameTriggers);
    window.addEventListener(EVENTS.SETUP_GAME, setupTriggers);
}
