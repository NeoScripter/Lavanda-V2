import { ROUND_TYPE, type GameInfo } from '../constants';
import { qs, qsa, shuffle, wait } from '../utils';

export default class GameRound {
    public run(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return this.randomCards();
            case ROUND_TYPE.LENORMAND:
                return this.lenormand();
            default:
                throw new Error('Unknown game round option');
        }
    }

    public cleanup(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return;
            case ROUND_TYPE.LENORMAND:
                return this.cleanupLenormand();
            default:
                throw new Error('Unknown game round option');
        }
    }

    private async randomCards() {
        const cards = qsa<HTMLLIElement>('[cmp-game]>li');

        let duration = 50;
        let currentIdx = 0;

        const handleNext = () => {
            const prevIdx =
                currentIdx === 0 ? cards.length - 1 : currentIdx - 1;
            cards[prevIdx].classList.remove('highlighted');
            cards[currentIdx].classList.add('highlighted');
            currentIdx = currentIdx === cards.length - 1 ? 0 : currentIdx + 1;

            cards[currentIdx].scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });
        };

        let extraDuration = Math.floor(Math.random() * 15);
        // const maxDuration = 400;
        const maxDuration = 100;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        cards.forEach((card) => card.classList.remove('highlighted'));
        return [cards[currentIdx]];
    }

    private async lenormand() {
        const keyCardMap = {
            man: ['джентльмен'],
            woman: ['дама'],
        };

        const game = qs<HTMLUListElement>('[cmp-game]');
        const cards = [...qsa<HTMLLIElement>('[cmp-game]>li')];

        const selectedCategoryBtn = qs<HTMLLIElement>(
            "[cmp-selected-lenormand][aria-selected='true']"
        );

        if (!selectedCategoryBtn) {
            throw new Error('No lenormand category is selected');
        }

        const selectedValue = selectedCategoryBtn
            .getAttribute('data-value')
            ?.trim();

        if (!selectedValue) {
            throw new Error("The lenormand picker doesn't contain a value");
        }

        if (!['man', 'woman'].includes(selectedValue)) {
            throw new Error("The lenormand picker's value is incorrect");
        }

        const keyCardArr =
            selectedValue === 'man' ? keyCardMap.man : keyCardMap.woman;

        const keyCard = cards.find((card) => {
            const dataName = card
                .getAttribute('data-name')
                ?.trim()
                .toLowerCase();

            if (!dataName) {
                throw new Error("The card doesn't have data-name attribute");
            }
            return keyCardArr.includes(dataName);
        });

        if (!keyCard) {
            throw new Error('Key card was not found');
        }

        for (const card of cards) {
            if (card === keyCard) {
                card.classList.add('accent');
            }
            card.classList.add('flipped');

            card.scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });

            await wait(200);
        }

        keyCard.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        await wait(1500);
        const keyCardPos = keyCard.getBoundingClientRect();

        const neighbors = [
            // Top
            ...document.elementsFromPoint(
                keyCardPos.right - keyCardPos.width / 2,
                keyCardPos.top - keyCardPos.height / 2
            ),
            // Bottom
            ...document.elementsFromPoint(
                keyCardPos.right - keyCardPos.width / 2,
                keyCardPos.bottom + keyCardPos.height / 2
            ),
            // Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.bottom - keyCardPos.height / 2
            ),
            // Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.bottom - keyCardPos.height / 2
            ),
        ].filter((item) => item != null && item.tagName.toLowerCase() === 'li');

        const corners = [
            // Top-Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.top - keyCardPos.height / 2
            ),
            // Top-Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.top - keyCardPos.height / 2
            ),
            // Bottom-Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.bottom + keyCardPos.height / 2
            ),
            // Bottom-Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.bottom + keyCardPos.height / 2
            ),
        ].filter((item) => item != null && item.tagName.toLowerCase() === 'li');

        const left = [
            // Top-Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.top - keyCardPos.height / 2
            ),
            // Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.bottom - keyCardPos.height / 2
            ),
            // Bottom-Left
            ...document.elementsFromPoint(
                keyCardPos.left - keyCardPos.width / 2,
                keyCardPos.bottom + keyCardPos.height / 2
            ),
        ].filter((item) => item != null && item.tagName.toLowerCase() === 'li');

        const right = [
            // Top-Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.top - keyCardPos.height / 2
            ),
            // Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.bottom - keyCardPos.height / 2
            ),
            // Bottom-Right
            ...document.elementsFromPoint(
                keyCardPos.right + keyCardPos.width / 2,
                keyCardPos.bottom + keyCardPos.height / 2
            ),
        ].filter((item) => item != null && item.tagName.toLowerCase() === 'li');
        const unique: HTMLLIElement[] = [];

        outer: for (const nei of neighbors) {
            for (const node of unique) {
                if (node === nei) continue outer;
            }

            unique.push(nei as HTMLLIElement);
        }

        for (const card of cards) {
            if (
                !unique.includes(card) &&
                card !== keyCard &&
                !corners.includes(card)
            ) {
                card.classList.add('hidden');
            } else if (corners.includes(card)) {
                card.classList.add('opacity-0');
            }
        }

        // Edge case left or right sides are empty

        if (left.length === 0) {
            game.setAttribute('two-cols', '');
            game.classList.add('shift-right');
        } else if (right.length === 0) {
            game.classList.add('shift-left');
            game.setAttribute('two-cols', '');
        } else {
            game.setAttribute('three-cols', '');
        }

        keyCard.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        await wait(1000);
        return unique;
    }

    private cleanupLenormand() {
        const cards = qsa<HTMLLIElement>('[cmp-game]>li');
        const game = qs<HTMLUListElement>('[cmp-game]');
        game.removeAttribute('three-cols');
        game.removeAttribute('two-cols');
        game.classList.remove('shift-right');
        game.classList.remove('shift-left');

        cards.forEach((card) => {
            card.classList.remove(
                'highlighted',
                'flipped',
                'accent',
                'hidden',
                'opacity-0'
            );
        });

        const shuffled = [...cards];
        shuffle(shuffled);

        const dFrag = document.createDocumentFragment();
        dFrag.append(...shuffled);
        game.innerHTML = '';
        game.appendChild(dFrag);
    }
}
