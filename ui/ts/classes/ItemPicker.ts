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

    public cleanup(info: GameInfo) {
        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.cleanupOneCard();
            default:
                throw new Error('Unknown game round option');
        }
    }

    private selectOneCard(card: HTMLLIElement) {
        card.classList.add('.flipped', '.highlighted');

        return card;
    }

    private cleanupOneCard() {
        const cards = qsa<HTMLLIElement>('li[cmp-flip-card]');

        cards.forEach((card) =>
            card.classList.remove('.flipped', '.highlighted')
        );
    }
}
