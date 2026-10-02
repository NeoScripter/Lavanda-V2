import GameHander from '../classes/gameHandler';
import { EVENTS } from '../constants';
import { qsa } from '../utils';

export default function initGameHanlders() {
    const handler = new GameHander();
    handler.init();
}
