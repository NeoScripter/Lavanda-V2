import { qsa, wait } from '../utils';

const TOTAL_CIRCLE_DURATION_MS = 10000;

export default function initBranchItems() {
    const branches = qsa<HTMLDivElement>('[cmp-branch-item]');

    async function animateSprite(sprites: NodeListOf<HTMLDivElement>) {
        sprites[sprites.length - 1].classList.add('opacity-0');
        for (let i = 0; i < sprites.length; i++) {
            sprites[i].classList.remove('opacity-0');
            await wait(Math.floor(TOTAL_CIRCLE_DURATION_MS / sprites.length));
            sprites[i].classList.add('opacity-0');
        }
        // sprites[sprites.length - 1].classList.remove('opacity-0');
    }

    async function animateWords(words: NodeListOf<HTMLSpanElement>) {

        for (const word of words) {
            word.classList.remove('opacity-0');
            await wait(Math.floor(TOTAL_CIRCLE_DURATION_MS / words.length));
        }

        words.forEach(word => word.classList.add('opacity-0'));
    }

    for (const branch of branches) {
        const sprites = qsa<HTMLDivElement>('[component-adaptive-image]', branch);
        const words = qsa<HTMLSpanElement>('[cmp-floating-word]', branch);

        animateSprite(sprites);
        animateWords(words);
        setInterval(() => animateSprite(sprites), TOTAL_CIRCLE_DURATION_MS);
        setInterval(() => animateWords(words), TOTAL_CIRCLE_DURATION_MS);
    }
}
