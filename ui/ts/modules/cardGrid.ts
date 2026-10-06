import { qsa } from '../utils';

export default function initCardGrid() {
    for (const grid of qsa<HTMLUListElement>('[cmp-card-grid]')) {
        adjustElements(grid);

        const resizeObserver = new ResizeObserver(() => adjustElements(grid));

        resizeObserver.observe(grid);
    }

    function adjustElements(grid: HTMLUListElement) {
        const cards = qsa<HTMLLIElement>('[cmp-flip-card]', grid);

        if (cards.length === 0) return;

        cards.forEach((card) => {
            card.removeAttribute('nth-2');
            card.removeAttribute('nth-3');
        });

        const firstCard = cards[0];

        const cardW = parseFloat(getComputedStyle(firstCard).width);
        const gridW = parseFloat(getComputedStyle(grid).width);
        const gap = parseFloat(getComputedStyle(grid).columnGap);

        const canFit = Math.floor((gridW + gap) / (cardW + gap));
        const rows = Math.ceil(cards.length / canFit) + 2;
        grid.style.setProperty('--rows', rows.toString());

        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const rowNum = Math.floor(i / canFit);
            const isNth2 = rowNum % 3 === 1;
            const isNth3 = rowNum % 3 === 2;

            if (isNth2) {
                card.setAttribute('nth-2', '');
            }
            if (isNth3) {
                card.setAttribute('nth-3', '');
            }
        }
    }
}
