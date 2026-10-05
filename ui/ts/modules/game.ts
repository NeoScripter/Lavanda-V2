import Game from '../classes/Game';
import { selectFirstVisibleElement } from '../utils';

export default function initGame() {
    const game = selectFirstVisibleElement<HTMLDivElement>('[cmp-game]', 'silent');

    if (!game) return;

    new Game().init();
}
