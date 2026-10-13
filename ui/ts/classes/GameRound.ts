import { ROUND_TYPE, type GameInfo } from '../constants';
import { getElementNeighbors, qs, qsa, shuffle, wait } from '../utils';

export default class GameRound {
    public run(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return this.randomCards();
            case ROUND_TYPE.LENORMAND:
                return this.lenormand();
            case ROUND_TYPE.RUNE:
                return this.runes();
            default:
                throw new Error('Unknown game round option');
        }
    }

    public cleanup(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return this.cleanupRandomCards();
            case ROUND_TYPE.LENORMAND:
                return this.cleanupLenormand();
            case ROUND_TYPE.RUNE:
                return this.cleanupRunes();
            default:
                throw new Error('Unknown game round option');
        }
    }
    private async runes() {
        const game = qs<HTMLUListElement>(
            '[cmp-planet-spinner]>[cmp-game][cmp-item-list]'
        );
        const runes = qsa<HTMLLIElement>(
            '[cmp-planet-spinner]>[cmp-game]>li:not(.hidden)'
        );
        game.style.setProperty('--count', runes.length.toString());

        let duration = 50;
        let offset = Number(game.style.getPropertyValue('--offset') ?? '0');

        const handleNext = async () => {
            offset++;
            const currentIdx = offset % runes.length;
            const prevIdx =
                currentIdx === 0 ? runes.length - 1 : currentIdx - 1;
            game.style.setProperty('--offset', offset.toString());

            runes[prevIdx].classList.remove('highlighted');
            runes[currentIdx].classList.add('highlighted');

            await wait(500);
            runes[currentIdx].scrollIntoView({
                block: 'center',
                behavior: 'smooth',
            });
        };

        let extraDuration = Math.floor(Math.random() * 10) + 5;
        const maxDuration = 200;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        const currentOffset = Number(
            game.style.getPropertyValue('--offset') ?? '0'
        );
        game.style.setProperty('--offset', currentOffset.toString());
        const selectedRune = runes[(currentOffset + runes.length) % runes.length];
        selectedRune.classList.add('hidden');
        return [selectedRune];
    }

    private cleanupRunes() {
        const runes = qsa<HTMLLIElement>(
            '[cmp-planet-spinner]>[cmp-game]>li[cmp-rune]'
        );
        const game = qs<HTMLUListElement>(
            '[cmp-planet-spinner]>[cmp-game][cmp-item-list]'
        );
        game.style.setProperty('--offset', '0');
        game.style.setProperty('--count', runes.length.toString());

        runes.forEach((rune) => {
            rune.classList.remove('highlighted');
        });
    }

    private async randomCards() {
        const cards = qsa<HTMLLIElement>('[cmp-game]>li:not(.hidden)');

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

        let extraDuration = Math.floor(Math.random() * 10) + 5;
        // const maxDuration = 400;
        const maxDuration = 200;

        while (duration < maxDuration) {
            handleNext();
            duration = Math.min(maxDuration, duration + extraDuration);
            await wait(duration);
        }

        cards.forEach((card) => card.classList.remove('highlighted'));
        cards[currentIdx].classList.add('hidden');
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
            '[cmp-selected-lenormand][aria-selected="true"]'
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

        const neighbors = getElementNeighbors(keyCard, ['T', 'D', 'L', 'R']);
        const corners = getElementNeighbors(keyCard, ['TL', 'DR', 'DL', 'TR']);
        const leftmost = getElementNeighbors(keyCard, ['L', 'TL', 'DL']);
        const rightmost = getElementNeighbors(keyCard, ['R', 'TR', 'DR']);

        for (const card of cards) {
            if (
                !neighbors.includes(card) &&
                card !== keyCard &&
                !corners.includes(card)
            ) {
                card.classList.add('hidden');
            } else if (corners.includes(card)) {
                card.classList.add('opacity-0');
            }
        }

        // Edge case left or right sides are empty

        if (leftmost.length === 0) {
            game.setAttribute('two-cols', '');
            game.classList.add('shift-right');
        } else if (rightmost.length === 0) {
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
        return neighbors;
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

    private cleanupRandomCards() {
        const cards = qsa<HTMLLIElement>('[cmp-game]>li');

        cards.forEach((card) => {
            card.classList.remove(
                'hidden',
            );
        });
    }
}
