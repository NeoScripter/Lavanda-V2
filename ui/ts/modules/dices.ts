import { qs, qsa } from '../utils';

export default function initDicePickers() {
    const dicePickers = qsa<HTMLDivElement>('[cmp-dice-picker]');

    for (const dicePicker of dicePickers) {
        const input = qs<HTMLInputElement>(
            'input[name="diceable_id"]',
            'error',
            dicePicker
        );

        const template = qs<HTMLTemplateElement>(
            '[cmp-selected-img-template]',
            'error',
            dicePicker
        );

        const availableDiceList = qs<HTMLUListElement>(
            '[cmp-available-dices]',
            'silent',
            dicePicker
        );

        if (!availableDiceList) return;

        const selectedDiceList = qs<HTMLUListElement>(
            '[cmp-selected-dices]',
            'silent',
            dicePicker
        );

        const submitBtn = qs<HTMLButtonElement>(
            '[cmp-submit-form-btn]',
            'silent'
        );

        const inputErrors = qsa<HTMLParagraphElement>(
            '[component-input-error]'
        );

        if (!selectedDiceList) return;

        const availableItems = qsa<HTMLLIElement>('li', availableDiceList);

        function handleDeselect(imgId: string) {
            const selectedRaw = input.value;

            if (selectedRaw == null) {
                input.value = imgId;
                return;
            }

            const selected = selectedRaw
                .split('|')
                .filter((chunk) => chunk !== '')
                .toSorted();

            input.value = selected
                .filter((id) => id !== imgId)
                .toSorted()
                .join('|');

            updateSelectedList();

            const match = Array.from(availableItems).find(
                (item) => item.getAttribute('data-imgbl-id') === imgId
            );

            if (!match) return;
        }

        function updateSelectedList() {
            if (!selectedDiceList) return;

            const selectedRaw = input.value;

            if (selectedRaw == null) {
                return;
            }

            const selected = selectedRaw
                .split('|')
                .filter((chunk) => chunk !== '')
                .toSorted();

            inputErrors.forEach((error) => {
                error.innerHTML = '';
                error.classList.add('hidden');
            });

            if (selected.length >= 2) {
                if (submitBtn) {
                    submitBtn.removeAttribute('disabled');
                }
            } else {
                if (submitBtn) {
                    submitBtn.setAttribute('disabled', 'true');
                }
            }

            selectedDiceList.innerHTML = '';

            for (const selectedImgId of selected) {
                const liClone = document.importNode(template.content, true);
                const li = qs<HTMLLIElement>('li', 'error', liClone);
                const image = qs<HTMLImageElement>('img', 'error', li);
                const button = qs<HTMLButtonElement>(
                    '[cmp-deselect-dice-btn]',
                    'error',
                    li
                );

                const match = Array.from(availableItems).find(
                    (item) =>
                        item.getAttribute('data-imgbl-id') === selectedImgId
                );

                if (!match) continue;

                const imgTag = qs<HTMLImageElement>('img', 'error', match);

                li.setAttribute('data-imgbl-id', selectedImgId);
                image.setAttribute('src', imgTag.getAttribute('src') ?? '');
                button.addEventListener('click', () =>
                    handleDeselect(selectedImgId)
                );

                selectedDiceList.appendChild(li);
            }
        }

        for (const item of availableItems) {
            const imgId = item.getAttribute('data-imgbl-id');

            if (!imgId) {
                throw new Error(
                    "Dice component doesn't have the data-imgbl-id attribute"
                );
            }

            const button = qs<HTMLButtonElement>(
                '[cmp-select-dice-btn]',
                'error',
                item
            );

            button.addEventListener('click', () => {
                const selectedRaw = input.value;

                if (selectedRaw == null) {
                    input.value = imgId;
                    return;
                }

                const selected = selectedRaw
                    .split('|')
                    .filter((chunk) => chunk !== '')
                    .toSorted();

                if (selected.length >= 2) return;

                selected.push(imgId);

                input.value = selected.toSorted().join('|');

                updateSelectedList();
            });
        }
    }
}
