import { qs } from '../utils';

export default async function initStoneGame() {
    const launchBtn = qs<HTMLButtonElement>('[cmp-show-cloth-btn]', 'silent');

    if (!launchBtn) return;

    const stoneGame = await import('../modules/stoneGame');
    stoneGame.default();
}
