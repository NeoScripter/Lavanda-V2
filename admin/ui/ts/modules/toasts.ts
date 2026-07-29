import { qs } from '../utils';

export default function initToasts() {
    const toast = qs<HTMLButtonElement>('[component-toast]', 'silent');

    if (!toast) return;

    const hide = () => {
        toast.classList.add('opacity-0');
        toast.classList.add('translate-y-[-400%]');
        setTimeout(() => toast.classList.add('hidden'), 1500);
    };

    // const show = () => {
    //     toast.classList.remove('opacity-0');
    //     toast.classList.remove('translate-y-[-400%]');
    //     toast.classList.remove('hidden');
    // };

    // setTimeout(() => show(), 10);
    setTimeout(() => hide(), 4000);

    const closeBtn = qs('button', 'error', toast);

    closeBtn.addEventListener('click', hide);
}
