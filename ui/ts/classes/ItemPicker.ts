import { PICKER_TYPE, type GameInfo } from '../constants';
import { qsa } from '../utils';

export default class ItemPicker {
    public select(button: HTMLButtonElement, info: GameInfo) {
        const card = button.closest(
            '[cmp-flip-card],[cmp-card]'
        ) as HTMLLIElement;

        if (!card) {
            throw new Error('Pickable card element was not found');
        }

        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.selectOneCard(card);
            default:
                throw new Error('Unknown game round option');
        }
    }

    public cleanup(item: HTMLElement, info: GameInfo) {
        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.cleanupOneCard(item);
            default:
                throw new Error('Unknown game round option');
        }
    }

    private selectOneCard(card: HTMLLIElement) {
        card.classList.add('flipped', 'pointer-events-none');

        return card;
    }

    private cleanupOneCard(item: HTMLElement) {
        item.classList.remove('flipped', 'pointer-events-none');
    }
}
