import { PICKER_TYPE, type GameInfo } from '../constants';

export default class ItemPicker {
    public select(button: HTMLButtonElement, info: GameInfo) {
        const item = button.closest(
            '[cmp-flip-card],[cmp-card],[cmp-rune],[cmp-flip-rune]'
        ) as HTMLLIElement;

        if (!item) {
            throw new Error('Pickable item element was not found');
        }

        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.selectOneCard(item);
            case PICKER_TYPE.ONE_RUNE:
                return this.selectOneRune(item);
            default:
                throw new Error('Unknown game round option');
        }
    }

    public cleanup(item: HTMLElement, info: GameInfo) {
        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.cleanupOneCard(item);
            case PICKER_TYPE.ONE_RUNE:
                return this.cleanupOneRune(item);
            default:
                throw new Error('Unknown game round option');
        }
    }

    private selectOneCard(card: HTMLLIElement) {
        card.classList.add('flipped', 'pointer-events-none');

        return card;
    }

    private selectOneRune(rune: HTMLLIElement) {
        rune.classList.add('flipped', 'pointer-events-none');

        return rune;
    }

    private cleanupOneCard(item: HTMLElement) {
        item.classList.remove('flipped', 'pointer-events-none');
    }

    private cleanupOneRune(rune: HTMLElement) {
        rune.classList.remove('flipped', 'pointer-events-none');
    }
}
