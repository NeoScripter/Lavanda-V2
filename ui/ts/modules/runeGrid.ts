import { EVENTS } from '../constants';
import { qs, qsa } from '../utils';

export default function initRuneGrid() {
    const grid = qs<HTMLDivElement>('[cmp-rune-grid]', 'silent');
    const shuffleRuneBtns = qsa<HTMLButtonElement>('[cmp-shuffle-runes-btn]');

    function adjustRuneSpread() {
        if (!grid) return;

        const factorX = window.innerWidth > 768 ? 18 : 8;
        const factorY = window.innerWidth > 768 ? 16 : 20;
        const runes = qsa<HTMLLIElement>('[cmp-flip-rune]', grid);

        for (const rune of runes) {
            const idx = Number(rune.style.getPropertyValue('--index') ?? '0');
            const rotation = Math.floor(Math.random() * idx * 50) + 'deg';
            const spreadX =
                Math.round((Math.random() - 1 + Math.random()) * factorX) * 20 +
                '%';
            const spreadY =
                Math.round((Math.random() - 1 + Math.random()) * factorY) * 20 +
                '%';

            rune.style.setProperty(
                'transform',
                `translateX(${spreadX}) translateY(${spreadY}) rotateZ(${rotation})`
            );
        }
    }

    if (!grid) return;

    shuffleRuneBtns.forEach((button) =>
        button.addEventListener('click', adjustRuneSpread)
    );
    window.addEventListener(EVENTS.SHUFFLE_RUNES, adjustRuneSpread);

    adjustRuneSpread();
    const resizeObserver = new ResizeObserver(adjustRuneSpread);

    resizeObserver.observe(grid);
}
