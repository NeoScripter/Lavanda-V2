import { qs, qsa } from '../utils';

export default function initAccordionFormInputs() {
    const accordions = qsa<HTMLDivElement>('[component-form-accordion]');

    for (const parent of accordions) {
        const list = qs<HTMLOListElement>(
            '[component-form-accordion-list]',
            'error',
            parent
        );
        const addBtn = qs<HTMLButtonElement>(
            '[component-accordion-add-item-btn]',
            'error',
            parent
        );
        const deleteBtn = qs<HTMLButtonElement>(
            '[component-accordion-delete-item-btn]',
            'error',
            parent
        );

        const template = qs<HTMLLIElement>('li', 'error', parent);

        function addNewItem() {
            const clone = template.cloneNode(true) as HTMLLIElement;

            if (!clone) return;

            const question = qs<HTMLInputElement>(
                '[component-accordion-question]',
                'error',
                clone
            );
            const answer = qs<HTMLInputElement>(
                '[component-accordion-answer]',
                'error',
                clone
            );

            const currentCount = qsa<HTMLLIElement>('li', list).length;

            question.name = question.name.replace(
                /\d+/,
                currentCount.toString()
            );
            question.value = '';
            answer.name = answer.name.replace(/\d+/, currentCount.toString());
            answer.value = '';

            list.appendChild(clone);

            deleteBtn.classList.remove('hidden!');
        }

        function deleteItem() {
            const currentCount = qsa<HTMLLIElement>('li', list).length;

            if (currentCount === 1) return;

            const lastItem = qs<HTMLLIElement>(
                'li:last-child',
                'error',
                parent
            );

            lastItem.remove();

            if (currentCount === 2) {
                deleteBtn.classList.add('hidden!');
            }
        }

        addBtn.addEventListener('click', addNewItem);
        deleteBtn.addEventListener('click', deleteItem);
    }
}
