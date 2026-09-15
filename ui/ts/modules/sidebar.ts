import { DISTANCE } from '../constants';
import { gid, qs } from '../utils';

export default function initSidebar() {
    const sidebar = gid<HTMLDivElement>('admin-sidebar');

    if (!sidebar) return;

    const aside = qs<HTMLDivElement>('aside', 'silent', sidebar);

    if (!aside) return;

    const handleResize = () => {
        if (window.matchMedia('(min-width:48rem)').matches) {
            hide();
        }
    };

    const resizeObserver = new ResizeObserver(handleResize);

    resizeObserver.observe(document.documentElement);

    const hide = () => {
        sidebar.classList.add('pointer-events-none');
        sidebar.classList.remove('bg-black/75');

        aside.classList.add('-translate-x-full');
        document.documentElement.style.overflowY = 'auto';
    };

    const show = () => {
        sidebar.classList.remove('pointer-events-none');
        sidebar.classList.add('bg-black/75');

        aside.classList.remove('-translate-x-full');
        document.documentElement.style.overflowY = 'hidden';
    };

    sidebar.addEventListener('click', (e) => {
        const el = e.target as HTMLElement | null;
        if (!el || el.id !== sidebar.id) return;

        hide();
    });

    let touchStartX: number | null = null;

    sidebar.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
    });

    sidebar.addEventListener('touchend', (e) => {
        if (touchStartX === null) return;

        const deltaX = e.changedTouches[0].clientX - touchStartX;

        if (Math.abs(deltaX) > DISTANCE.SWIPE_THRESHOLD) {
            e.preventDefault();

            if (deltaX < 0) {
                hide();
            }
        }

        touchStartX = null;
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            hide();
        }
    });

    const button = qs<HTMLButtonElement>('[data-open-sidebar-btn]');

    if (!button) return;

    button.addEventListener('click', show);
}
