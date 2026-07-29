import { qs } from '../utils';

export default function initScrollToInputError() {
    const error = qs<HTMLDivElement>('[component-input-error]', 'silent');

    if (!error) return;

    error.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
        inline: 'nearest',
    });
}
