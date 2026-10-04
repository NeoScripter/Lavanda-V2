// component-app-header

import { qs } from '../utils';

const THRESHOLD_PX = 50;

export default function initHeader() {
    const header = qs<HTMLDivElement>('[component-app-header]', 'silent');

    if (!header) return;

    let prevPosition = 0;
    let ticking = false;

    const event = 'scrollend' in window ? 'scrollend' : 'scroll';

    window.addEventListener(event, () => {
        if (!ticking) {
            setTimeout(() => {
                const currentPosition = window.scrollY;

                if (currentPosition - prevPosition > THRESHOLD_PX) {
                    header.style.setProperty('transform', 'translateY(-150%)');
                } else if (prevPosition - currentPosition > 0) {
                    header.style.removeProperty('transform');
                }
                prevPosition = currentPosition;
                ticking = false;
            }, 20);
        }

        ticking = true;
    });
}
