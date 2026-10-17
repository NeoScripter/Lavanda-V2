import { qs, qsa, wait } from '../utils';

type Payload = {
    number: number;
    description: string;
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
    const dices = qsa<HTMLDivElement>('[cmp-dice]', container);

    launchGameBtns.forEach((button) =>
        button.addEventListener('click', launchGameRound)
    );
    resetGameBtns.forEach((button) => button.addEventListener('click', reset));

    async function launchGameRound() {
        disableBtns();
        setState('during');

        const winnerIds = await Promise.all(
            [...dices].map((dice) => throwDice(dice))
        );
        console.log(winnerIds);

        setState('end');
        // await showOutcome(bitmask);

        enableBtns();
    }

    function reset() {
        setState('start');
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
        return winnerId;
    }

    async function showOutcome(bitmask: number) {
        const API_URL = '/api/dice';
        const queryParams = { bitmask: bitmask.toString() };

        if (container) {
            container.appendChild(document.importNode(preloader.content, true));
        }

        let payload: Payload | null = null;
        try {
            const queryString = new URLSearchParams(queryParams).toString();
            const url = `${API_URL}?${queryString}`;

            // await wait(2000);
            const response = await fetch(url);
            payload = await response.json();
        } catch (error) {
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

        inter.classList.remove('hidden');
    }

    function disableBtns() {
        launchGameBtns.forEach((btn) => btn.setAttribute('disabled', 'true'));
    }
    function enableBtns() {
        launchGameBtns.forEach((btn) => btn.removeAttribute('disabled'));
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
