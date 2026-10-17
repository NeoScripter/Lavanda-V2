import { qs } from '../utils';

export default async function initIchingGame() {
    const container = qs<HTMLDivElement>('[cmp-iching-game]', 'silent');

    if (!container) return;

    const game = await import('../modules/ichingGame');
    game.default();
}
