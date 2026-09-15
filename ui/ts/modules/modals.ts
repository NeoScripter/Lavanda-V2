import { DURATION, EVENTS } from '../constants';
import { gid, qs, qsa } from '../utils';

export default function initModals() {
    const modalTemplates = qsa<HTMLTemplateElement>(
        '[component-modal-template]'
    );
    const modalContainer = gid<HTMLDivElement>('modals');

    const hideModal = () => {
        const modal = qs<HTMLDivElement>(
            '[component-modal]',
            'silent',
            modalContainer
        );

        if (!modal) return;

        modal.classList.add('opacity-0');

        const modalSlot = qs<HTMLDivElement>(
            '[component-modal-slot]',
            'error',
            modal
        );

        modalSlot.classList.add('animate-shrink');
        modalSlot.classList.remove('animate_expand');

        setTimeout(() => {
            if (modal) {
                modal.remove();
            }
        }, DURATION.MODAL_TRANSITION_MS);

        document.documentElement.style.overflowY = '';
    };

    const openModal = (template: HTMLTemplateElement) => {
        const fragment = document.importNode(
            template.content,
            true
        ) as DocumentFragment;

        modalContainer.append(fragment);

        const modal = qs<HTMLDivElement>(
            '[component-modal]',
            'error',
            modalContainer
        );

        modal.classList.remove('hidden', 'opacity-0');
        modal.classList.add('flex');

        const modalSlot = qs<HTMLDivElement>(
            '[component-modal-slot]',
            'error',
            modal
        );
        modalSlot.classList.remove('animate-shrink');
        modalSlot.classList.add('animate_expand');

        modal.addEventListener('click', (e: MouseEvent) => {
            const target = e.target as HTMLElement;
            if (!e.target) return;

            const isOverlay = !modalSlot.contains(target);
            const shouldHideOnClick =
                target.classList.contains('closes-on-click');

            if (isOverlay || shouldHideOnClick) {
                hideModal();
            }
        });

        document.documentElement.style.overflowY = 'hidden';

        const dismissModalTrigger = qs<HTMLButtonElement>(
            '[component-modal-dismiss]',
            'silent',
            modal
        );

        if (!dismissModalTrigger) return;

        dismissModalTrigger.addEventListener('click', hideModal);
    };

    document.addEventListener(EVENTS.HIDE_MODAL, hideModal);
    document.addEventListener('keydown', (e: KeyboardEvent) => {
        if (e.key === 'Escape') {
            hideModal();
        }
    });

    for (const template of modalTemplates) {
        const modalId = template.getAttribute('data-modal-id')?.toString();

        if (!modalId) continue;

        document.addEventListener(modalId, () => openModal(template));
    }

    const showModalTriggers = qsa<HTMLButtonElement>('[component-modal-show]');

    for (const trigger of showModalTriggers) {
        const modalId = trigger.getAttribute('data-modal-id')?.toString();

        if (!modalId) continue;

        trigger.addEventListener('click', () => {
            document.dispatchEvent(new CustomEvent(modalId));
            document.dispatchEvent(new CustomEvent(EVENTS.SHOW_MODAL));
        });
    }
}
