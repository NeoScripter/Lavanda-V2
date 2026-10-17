import { qs, qsa } from '../utils';

export default function stoneGame() {
    const launchBtn = qs<HTMLButtonElement>('[cmp-show-cloth-btn]', 'error');

    const visibleAtStart = qsa<HTMLElement>('[cmp-visible-at-start]');
    const visibleAtEnd = qsa<HTMLElement>('[cmp-visible-at-end]');
    const visibleDuring = qsa<HTMLElement>('[cmp-visible-during]');

    launchBtn.addEventListener('click', () => {
        visibleAtStart.forEach((el) => el.classList.add('hidden'));
        visibleAtEnd.forEach((el) => el.classList.add('hidden'));

        visibleDuring.forEach((el) => el.classList.remove('hidden'));
    });
}
