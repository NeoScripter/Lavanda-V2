import GameStage from '../classes/GameStage';
import { qs, qsa } from '../utils';

export default async function initGame() {
    const interContainer = qs<HTMLDivElement>('[cmp-interpretation]', 'silent');
    new GameStage().init();

    if (!interContainer) return;

    const Interpretation = await import('../classes/Interpretation');
    const interpretation = new Interpretation.default(interContainer);

    const Game = await import('../classes/Game');

    for (const game of qsa<HTMLElement>('[cmp-game-container]')) {
        new Game.default(game, interpretation).init();
    }
}
