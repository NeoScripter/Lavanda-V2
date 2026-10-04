import { qs, qsa } from '../utils';

export default function initAdaptiveImages() {
    const adaptiveImgs = qsa<HTMLDivElement>('[component-adaptive-image]');

    adaptiveImgs.forEach((container) => {
        const img = qs<HTMLImageElement>('img', 'silent', container);

        if (!img) {
            return;
        }

        const handleImgLoad = () => {
            img.classList.remove('opacity-0');

            const overlay = qs('[component-overlay]', 'silent', container);

            if (overlay) {
                overlay.remove();
            }

            setTimeout(() => (container.style.backgroundImage = 'none'), 500);
        };

        if (img.complete) {
            handleImgLoad();
        } else {
            img.addEventListener('load', () => handleImgLoad());
        }
    });
}
