import { qsa, wait } from '../utils';

export default function initBranchItems() {
    const branches = qsa<HTMLDivElement>('[cmp-branch-item]');

    async function animateBranch(items: NodeListOf<HTMLDivElement>) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('opacity-0');
            await wait(750)
            items[i].classList.add('opacity-0');
        }
    }

    for (const branch of branches) {
        const items = qsa<HTMLDivElement>('[component-adaptive-image]', branch);

        animateBranch(items);
        setInterval(() => animateBranch(items), 3750)

    }
}
