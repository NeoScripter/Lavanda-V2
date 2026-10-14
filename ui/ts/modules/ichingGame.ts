import convertArrayToBinary, { qs, qsa, wait } from '../utils';
import initAdaptiveImages from './adaptiveImages';

const INITIAL_DELAY = 50;

type Payload = {
    number: number;
    description: string;
};

export default function initIchingGame() {
    const container = qs<HTMLDivElement>('[cmp-iching-game]', 'silent');

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

    const scheme = qs<HTMLTemplateElement>('[cmp-iching-scheme]');
    const preloader = qs<HTMLTemplateElement>('[cmp-iching-preloader]');

    const patterns = [
        ...qsa<HTMLDivElement>('[cmp-iching-pattern]', container),
    ].toSorted(
        (a, b) =>
            Number(a.getAttribute('cmp-iching-pattern')) -
            Number(b.getAttribute('cmp-iching-pattern'))
    );

    const ichingLines = [
        ...qsa<HTMLDivElement>('[cmp-iching-line]', container),
    ].toSorted(
        (a, b) =>
            Number(a.getAttribute('cmp-iching-line')) -
            Number(b.getAttribute('cmp-iching-line'))
    );

    const coins = qsa<HTMLDivElement>('[cmp-flip-coin]', container);

    const ichingInter = qs<HTMLParagraphElement>(
        '[cmp-iching-interpretation]',
        'error',
        container
    );
    const ichingNum = qs<HTMLParagraphElement>(
        '[cmp-iching-num]',
        'error',
        container
    );

    const inter = qs<HTMLDivElement>('[cmp-interpretation]');

    const marked: number[] = [];

    launchGameBtns.forEach((button) =>
        button.addEventListener('click', launchGameRound)
    );
    resetGameBtns.forEach((button) => button.addEventListener('click', reset));

    async function launchGameRound() {
        disableBtns();
        setState('during');

        const outcome = await Promise.all(
            [...coins].map((coin) => flipCoin(coin, INITIAL_DELAY))
        );

        const isTales =
            outcome.reduce((acc, coin) => Number(coin) + acc, 0) > 1;
        marked.push(Number(isTales));

        patterns[marked.length - 1].classList.remove('masked');
        if (!isTales) {
            patterns[marked.length - 1].classList.add('split');
        }

        if (marked.length === patterns.length) {
            setState('end');
            const bitmask = convertArrayToBinary(marked);
            await showOutcome(bitmask);
        }

        enableBtns();
    }

    function reset() {
        setState('start');
        inter.innerHTML = '';
        marked.length = 0;
        inter.classList.add('hidden');
        coins.forEach((coin) => {
            coin.classList.remove('flipped');
            coin.classList.add('still');
            coin.style.setProperty('--rotation', '180');
        });
        patterns.forEach((pattern) => {
            pattern.classList.remove('split');
            pattern.classList.add('masked');
        });
        ichingLines.forEach((line) => line.classList.remove('split'));
    }

    async function showOutcome(bitmask: number) {
        const API_URL = '/api/iching';
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

        ichingInter.textContent = payload.description;
        ichingNum.textContent = payload.number.toString();

        ichingLines.forEach((line, idx) => {
            if (marked[idx] !== 1) {
                line.classList.add('split');
            }
        });

        inter.appendChild(document.importNode(scheme.content, true));
        inter.classList.remove('hidden');
        initAdaptiveImages();
    }

    async function flipCoin(coin: HTMLDivElement, currentDelay: number) {
        coin.classList.remove('still');
        const currentRotation = parseFloat(
            coin.style.getPropertyValue('--rotation')
        );
        coin.style.setProperty(
            '--rotation',
            (currentRotation + 180).toString()
        );
        const surface = qs<HTMLDivElement>('[cmp-surface]', 'error', coin);
        surface.style.transitionDuration = `${currentDelay}ms`;

        if (currentDelay > 35 && currentDelay < 40) {
            const shouldFlip = Math.round(Math.random()) === 0;

            if (shouldFlip) {
                coin.classList.add('flipped');
            } else {
                coin.classList.remove('flipped');
            }

            currentDelay = 35;
        }

        if (currentDelay > 20) {
            const increase = Math.round(Math.random() * 2);
            const nextDelay = currentDelay - increase;

            await wait(currentDelay);

            if (container) {
                container.scrollIntoView({
                    block: 'center',
                    behavior: 'smooth',
                });
            }

            return flipCoin(coin, nextDelay);
        }

        coin.classList.add('still');
        return coin.classList.contains('flipped');
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
