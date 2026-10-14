import { EVENTS, PICKER_TYPE, type GameInfo } from '../constants';
import initAdaptiveImages from '../modules/adaptiveImages';
import { getRandomItem, qs, qsa, wait } from '../utils';

export default class ItemPicker {
    public select(button: HTMLButtonElement, info: GameInfo) {
        const item = button.closest(
            '[cmp-flip-card],[cmp-card],[cmp-rune],[cmp-flip-rune],[cmp-stone-cloth]'
        ) as HTMLLIElement;

        if (!item) {
            throw new Error('Pickable item element was not found');
        }

        switch (info.picker) {
            case PICKER_TYPE.ONE_CARD:
                return this.selectOneCard(item);
            case PICKER_TYPE.ONE_RUNE:
                return this.selectOneRune(item);
            case PICKER_TYPE.ONE_STONE:
                return this.selectOneStone(item as unknown as HTMLDivElement);
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
            case PICKER_TYPE.ONE_STONE:
                return this.cleanupOneStone(item);
            default:
                throw new Error('Unknown game round option');
        }
    }

    private selectOneCard(card: HTMLLIElement) {
        card.classList.add('flipped', 'pointer-events-none');

        return card;
    }

    private async selectOneStone(item: HTMLDivElement) {
        const winner = qs<HTMLDivElement>('[cmp-winner-stone]', 'error', item);
        winner.classList.remove('hidden');

        await wait(2000);

        return item;
    }

    private selectOneRune(rune: HTMLLIElement) {
        rune.classList.add('flipped', 'pointer-events-none');
        window.dispatchEvent(new CustomEvent(EVENTS.SHUFFLE_RUNES));

        return rune;
    }

    private cleanupOneCard(item: HTMLElement) {
        item.classList.remove('flipped', 'pointer-events-none');
    }

    private cleanupOneRune(rune: HTMLElement) {
        rune.classList.remove('flipped', 'pointer-events-none');
        rune.style.removeProperty('transform');
    }

    private cleanupOneStone(item: HTMLElement) {
        const winner = qs<HTMLDivElement>('[cmp-winner-stone]', 'silent', item);

        if (!winner) {
            return;
        }

        winner.classList.add('hidden');
        const prevImgSrc = item.getAttribute('data-prev-image');
        const prevImgAlt = item.getAttribute('data-prev-alt') ?? 'No image alt';

        if (!prevImgSrc) {
            throw new Error(
                "Stone cloth doesn't contain the data-prev-image attribute"
            );
        }
        const stones = qsa<HTMLLIElement>('[cmp-stone-grid] [cmp-stone]');

        const randomStone = getRandomItem([...stones]);

        if (randomStone) {
            const nextImgSrc = randomStone.getAttribute('data-image');
            const nextStoneId = randomStone.getAttribute('data-id');
            const nextImgAlt =
                randomStone.getAttribute('data-alt') ?? 'No image alt';

            if (nextImgSrc) {
                winner.innerHTML = winner.innerHTML.replaceAll(
                    prevImgSrc,
                    nextImgSrc
                );
                item.setAttribute('data-prev-image', nextImgSrc);
            }

            if (nextImgAlt !== '') {
                winner.innerHTML = winner.innerHTML.replace(
                    prevImgAlt,
                    nextImgAlt
                );
                item.setAttribute('data-prev-alt', nextImgAlt);
            }
            if (nextStoneId) {
                item.setAttribute('data-id', nextStoneId);
            }
            initAdaptiveImages();
        }
    }
}
