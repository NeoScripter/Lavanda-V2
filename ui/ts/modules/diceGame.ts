import { qs, qsa, wait } from '../utils';

type Payload = {
    html: string;
};

export default function initDiceGame() {
    const container = qs<HTMLDivElement>('[cmp-dice-game]', 'silent');

    if (!container) return;

    const visibleAtStart = qsa<HTMLElement>(
        '[cmp-visible-at-start]',
        container
    );
    const visibleAtEnd = qsa<HTMLElement>('[cmp-visible-at-end]', container);
    const visibleDuring = qsa<HTMLElement>('[cmp-visible-during]', container);
    const launchGameBtns = qsa<HTMLButtonElement>(
        '[cmp-launch-game-btn]',
        container
    );
    const resetGameBtns = qsa<HTMLButtonElement>(
        '[cmp-reset-game-btn]',
        container
    );

    const preloader = qs<HTMLTemplateElement>('[cmp-dice-preloader]');

    const inter = qs<HTMLParagraphElement>(
        '[cmp-dice-interpretation]',
        'error',
        container
    );

    const themeSelector = qs<HTMLSelectElement>('#theme-select');

    const dices = qsa<HTMLDivElement>('[cmp-dice]', container);

    launchGameBtns.forEach((button) =>
        button.addEventListener('click', launchGameRound)
    );
    resetGameBtns.forEach((button) => button.addEventListener('click', reset));

    async function launchGameRound() {
        disableBtns();
        setState('during');
        const theme = themeSelector.value.toLowerCase();

        const winnerIds = await Promise.all(
            [...dices].map((dice) => throwDice(dice))
        );

        setState('end');
        await showOutcome(theme, winnerIds.toSorted().join('|'));

        enableBtns();
    }

    function reset() {
        setState('start');
        dices.forEach((dice) => {
            dice.setAttribute('cmp-dice', '');
            if (dice.nextElementSibling) {
                dice.nextElementSibling.textContent = '';
                dice.nextElementSibling.classList.add('hidden');
            }
        });
        inter.innerHTML = '';
        inter.classList.add('hidden');
    }

    async function throwDice(dice: HTMLDivElement) {
        for (let i = 1; i <= 6; i++) {
            const val = Math.round(Math.random()) === 0 ? -1 : 1;
            dice.style.setProperty(`--dir${i}`, val.toString());
        }
        dice.classList.add('throw');
        await wait(750 * 5);
        dice.classList.remove('throw');

        const winnerId = Math.floor(Math.random() * 6) + 1;

        dice.setAttribute('cmp-dice', `${winnerId}`);
        await wait(105);

        const nameContainer = dice.nextElementSibling;

        if (!nameContainer) {
            throw new Error('Name container was not found');
        }

        const winnerFace = qs<HTMLDivElement>(
            `[cmp-dice-face][data-id="${winnerId}"]`,
            'error',
            dice
        );
        const name = winnerFace.getAttribute('data-name');
        nameContainer.textContent = name;
        nameContainer.classList.remove('hidden');

        return winnerId;
    }

    async function showOutcome(theme: string, winnerId: string) {
        const API_URL = '/api/dice';

        inter.appendChild(document.importNode(preloader.content, true));
        inter.classList.remove('hidden');

        let payload: Payload | null = null;
        try {
            const queryString = new URLSearchParams({
                theme,
                winner_id: winnerId,
            }).toString();
            const url = `${API_URL}?${queryString}`;

            const response = await fetch(url);
            payload = await response.json();
        } catch (error) {
            inter.classList.add('hidden');
            console.log(error);
        } finally {
            if (container) {
                const skeleton = qs<HTMLDivElement>(
                    '[cmp-skeleton]',
                    'silent',
                    container
                );
                skeleton?.remove();
            }
        }

        if (payload === null) return;

        inter.innerHTML = payload.html;
    }

    function disableBtns() {
        [...launchGameBtns, ...resetGameBtns].forEach((btn) =>
            btn.setAttribute('disabled', 'true')
        );
    }
    function enableBtns() {
        [...launchGameBtns, ...resetGameBtns].forEach((btn) =>
            btn.removeAttribute('disabled')
        );
    }

    function setState(type: 'start' | 'during' | 'end') {
        [...visibleAtStart, ...visibleAtEnd, ...visibleDuring].forEach((el) =>
            el.classList.add('hidden')
        );

        if (type === 'start') {
            visibleAtStart.forEach((el) => el.classList.remove('hidden'));
        } else if (type === 'end') {
            visibleAtEnd.forEach((el) => el.classList.remove('hidden'));
        } else {
            visibleDuring.forEach((el) => el.classList.remove('hidden'));
        }
    }
}
