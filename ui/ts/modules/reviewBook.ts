import { qs, qsa, wait } from '../utils';

export default function initReviewBook() {
    const reviewContainer = qs<HTMLParagraphElement>('[cmp-reviews]', 'silent');

    if (!reviewContainer) return;

    let currentIdx = 0;

    const currentReview = qs<HTMLParagraphElement>(
        '[cmp-current-review]',
        'error',
        reviewContainer
    );
    const prevReviewButtons = qsa<HTMLButtonElement>(
        '[cmp-prev-review]',
        reviewContainer
    );
    const nextReviewButtons = qsa<HTMLButtonElement>(
        '[cmp-next-review]',
        reviewContainer
    );
    const dataReviewButtons = qsa<HTMLButtonElement>(
        '[data-review]',
        reviewContainer
    );

    for (let i = 0; i < dataReviewButtons.length; i++) {
        const button = dataReviewButtons[i];

        button.addEventListener('click', () => {
            currentIdx = i;
            updateReview();
        });
    }

    prevReviewButtons.forEach((button) => {
        button.addEventListener('click', () => {
            currentIdx =
                currentIdx === 0
                    ? dataReviewButtons.length - 1
                    : currentIdx - 1;
            updateReview();
        });
    });

    nextReviewButtons.forEach((button) => {
        button.addEventListener('click', () => {
            currentIdx =
                currentIdx === dataReviewButtons.length - 1
                    ? 0
                    : currentIdx + 1;
            updateReview();
        });
    });

    async function updateReview() {
        const newReview =
            dataReviewButtons[currentIdx].getAttribute('data-review');

        if (!newReview) {
            throw new Error('data-review attribute was not found');
        }

        [
            ...prevReviewButtons,
            ...nextReviewButtons,
            ...dataReviewButtons,
        ].forEach((btn) => btn.setAttribute('disabled', 'true'));

        currentReview.classList.add('opacity-0');

        dataReviewButtons.forEach(btn => {btn.classList.remove('bg-primary'); btn.classList.add('bg-gray-400')});

        await wait(500);

        currentReview.textContent = newReview;
        currentReview.classList.remove('opacity-0');

        dataReviewButtons[currentIdx].classList.remove('bg-gray-400');
        dataReviewButtons[currentIdx].classList.add('bg-primary');

        await wait(500);

        [
            ...prevReviewButtons,
            ...nextReviewButtons,
            ...dataReviewButtons,
        ].forEach((btn) => btn.removeAttribute('disabled'));
    }
}
