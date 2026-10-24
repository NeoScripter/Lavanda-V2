import { ROUND_TYPE, type GameInfo } from '../constants';
import initAdaptiveImages from '../modules/adaptiveImages';
import {
    getElementNeighbors,
    getRandomItem,
    qs,
    qsa,
    shuffle,
    wait,
} from '../utils';

export default class GameRound {
    public run(info: GameInfo) {
        switch (info.round) {
            case ROUND_TYPE.RANDOM_CARDS:
                return this.randomCards();
            case ROUND_TYPE.LENORMAND:
                return this.lenormand();
            case ROUND_TYPE.RUNE:
                return this.runes();
            case ROUND_TYPE.STONE:
                return this.stones();
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
            case ROUND_TYPE.STONE:
                return this.cleanupStones();
            default:
                throw new Error('Unknown game round option');
        }
    }

    private async stones() {
        const game = qs<HTMLDivElement>('[cmp-random-stone-game]', 'error');
        const initialSack = qs<HTMLDivElement>(
            '[cmp-initial-sack]',
            'error',
            game
        );
        const closedSack = qs<HTMLDivElement>(
            '[cmp-closed-sack]',
            'error',
            game
        );
        const openSack = qs<HTMLDivElement>('[cmp-open-sack]', 'error', game);
        const openSackImage = qs<HTMLDivElement>(
            '[cmp-open-sack] > [component-adaptive-image]:first-child',
            'error',
            openSack
        );

        const selectedStone = qs<HTMLDivElement>(
            '[cmp-selected-stone]',
            'error',
            game
        );

        game.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        initialSack.classList.add('opacity-0');
        closedSack.classList.remove('opacity-0');
        await wait(500);
        initialSack.classList.add('hidden');
        await wait(1000);

        game.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        closedSack.classList.add('opacity-0');
        openSack.classList.remove('hidden');
        await wait(500);
        closedSack.classList.add('hidden');
        await wait(1000);

        game.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        openSackImage.classList.add('opacity-0');
        await wait(500);
        selectedStone.classList.remove('appearing');
        openSackImage.classList.add('hidden');

        game.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });

        await wait(1000);

        return [game];
    }

    private cleanupStones() {
        const game = qs<HTMLDivElement>('[cmp-random-stone-game]', 'error');

        const initialSack = qs<HTMLDivElement>('[cmp-initial-sack]');
        const closedSack = qs<HTMLDivElement>('[cmp-closed-sack]');
        const openSack = qs<HTMLDivElement>('[cmp-open-sack]');
        const openSackImage = qs<HTMLDivElement>(
            '[cmp-open-sack] > [component-adaptive-image]:first-child',
            'error',
            openSack
        );

        const winner = qs<HTMLDivElement>(
            '[cmp-selected-stone]',
            'error',
            game
        );

        initialSack.classList.remove('opacity-0', 'hidden');
        closedSack.classList.add('opacity-0');
        closedSack.classList.remove('hidden');
        openSack.classList.add('hidden');
        openSackImage.classList.remove('opacity-0', 'hidden');
        winner.classList.add('appearing');

        const prevImgSrc = game.getAttribute('data-prev-image');
        const prevImgAlt = game.getAttribute('data-prev-alt') ?? 'No image alt';

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
                game.setAttribute('data-prev-image', nextImgSrc);
            }

            if (nextImgAlt !== '') {
                winner.innerHTML = winner.innerHTML.replace(
                    prevImgAlt,
                    nextImgAlt
                );
                game.setAttribute('data-prev-alt', nextImgAlt);
            }

            if (nextStoneId) {
                game.setAttribute('data-id', nextStoneId);
            }

            initAdaptiveImages();
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
        const selectedRune =
            runes[(currentOffset + runes.length) % runes.length];
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
            rune.classList.remove('highlighted', 'hidden');
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
        const maxDuration = 400;

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
            man: ['джентльмен', 'gentleman', 'џентлмен'],
            woman: ['дама', 'dame'],
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
            card.classList.remove('hidden');
        });
    }
}
