import { DURATION, EVENTS } from '../constants';
import { gid, qs, qsa } from '../utils';

export default function initMatchSetPickers() {
    const setPickers = qsa<HTMLDivElement>('[component-match-set-picker]');

    for (const setPicker of setPickers) {
        const input = qs<HTMLInputElement>(
            'input[name="matcheable_id"]',
            'error',
            setPicker
        );

        const template = qs<HTMLTemplateElement>(
            '[component-selected-img-template]',
            'error',
            setPicker
        );

        const availableSetList = qs<HTMLUListElement>(
            '[component-available-sets]',
            'silent',
            setPicker
        );

        if (!availableSetList) return;

        const selectedSetList = qs<HTMLUListElement>(
            '[component-selected-sets]',
            'silent',
            setPicker
        );

        if (!selectedSetList) return;

        const availableItems = qsa<HTMLLIElement>('li', availableSetList);

        function handleDeselect(imgId: string) {
            const selectedRaw = input.value;

            if (selectedRaw == null) {
                input.value = imgId;
                return;
            }

            const selected = selectedRaw
                .split('|')
                .filter((chunk) => chunk !== '');

            input.value = selected.filter(id => id !== imgId).join('|');

            updateSelectedList();

            const match = Array.from(availableItems).find(
                (item) => item.getAttribute('data-imgbl-id') === imgId
            );

            if (!match) return;

            match.removeAttribute('style')
        }

        function updateSelectedList() {
            if (!selectedSetList) return;

            const selectedRaw = input.value;

            if (selectedRaw == null) {
                return;
            }

            const selected = selectedRaw
                .split('|')
                .filter((chunk) => chunk !== '');

            selectedSetList.innerHTML = '';

            for (const selectedImgId of selected) {
                const liClone = document.importNode(template.content, true);
                const li = qs<HTMLLIElement>('li', 'error', liClone);
                const image = qs<HTMLImageElement>('img', 'error', li);
                const button = qs<HTMLButtonElement>(
                    '[component-deselect-set-btn]',
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
                button.addEventListener('click', () => handleDeselect(selectedImgId));

                selectedSetList.appendChild(li)
            }
        }

        for (const item of availableItems) {
            const imgId = item.getAttribute('data-imgbl-id');

            if (!imgId) {
                throw new Error(
                    "Match Set component doesn't have the data-imgbl-id attribute"
                );
            }

            const button = qs<HTMLButtonElement>(
                '[component-select-set-btn]',
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
                    .filter((chunk) => chunk !== '');

                if (selected.includes(imgId)) return;

                selected.push(imgId);

                input.value = selected.join('|');

                item.style.display = 'none';

                updateSelectedList();
            });
        }
    }
}
