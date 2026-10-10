import { qsa, wait } from '../utils';

export default function initBranchItems() {
    const branches = qsa<HTMLDivElement>('[cmp-branch-item]');

    async function animateBranch(items: NodeListOf<HTMLDivElement>) {
        items[items.length - 1].classList.add('opacity-0');
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('opacity-0');
            await wait(500);
            items[i].classList.add('opacity-0');
        }
        items[items.length - 1].classList.remove('opacity-0');
    }

    for (const branch of branches) {
        const items = qsa<HTMLDivElement>('[component-adaptive-image]', branch);

        animateBranch(items);
        setInterval(() => animateBranch(items), 3750);
    }
}
