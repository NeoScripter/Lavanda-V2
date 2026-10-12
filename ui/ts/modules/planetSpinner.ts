import { qs } from '../utils';

export default function initPlanetSpinner() {
    const spinner = qs<HTMLDivElement>('[cmp-planet-spinner]', 'silent');

    if (!spinner) return;

    const list = qs<HTMLUListElement>('[cmp-item-list]', 'error', spinner);

    function adjustItemSize() {
        const sizeRatio = list.getAttribute('data-item-size-ratio') ?? '12';

        const listW = list.offsetWidth;
        const itemW = Math.max(Math.floor(listW / Number(sizeRatio)), 55);
        list.style.setProperty('--item-size', `${itemW}px`);
    }

    adjustItemSize();

    const resizeObserver = new ResizeObserver(adjustItemSize);

    resizeObserver.observe(list);
}
