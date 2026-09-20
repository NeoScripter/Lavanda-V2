import { gid, qsa } from '../utils';

export default function initNavMenu() {
    const navMenuBtn = gid<HTMLDivElement>('nav-burger-menu-btn');
    const navMenus = qsa<HTMLDivElement>('[component-nav-menu]');

    if (!navMenuBtn) return;

    for (const navMenu of navMenus) {
        navMenuBtn.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                navMenu.classList.add('hidden');
            }
        });

        const handleResize = () => {
            if (window.matchMedia('(min-width:48rem)').matches) {
                navMenu.classList.remove('hidden');
            } else {
                navMenu.classList.add('hidden');
            }
        };

        const resizeObserver = new ResizeObserver(handleResize);

        resizeObserver.observe(document.documentElement);
    }
}
