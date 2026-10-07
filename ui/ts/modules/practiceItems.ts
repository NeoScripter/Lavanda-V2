import { createElements, qs, wait, qsa } from '../utils';
import initAdaptiveImages from './adaptiveImages';

type ItemType = {
    title: string;
    description: string;
    file: string | null;
    img_alt: string | null;
    img_src: string;
    faqs: string | null;
};

type Entry = {
    id: number;
    isActive: boolean;
    item: ItemType;
};

export default async function initPracticeItems() {
    const grid = qs<HTMLUListElement>('[component-practice-grid]', 'silent');

    const items = qsa<HTMLLIElement>('[data-practice-item-id]');

    if (!grid) return;

    const payload = await fetchAllItems();
    const entries: Entry[] = [];
    let prevColNum = calculateColumnNum();

    for (const entry of payload) {
        entries.push({
            id: entry.id,
            isActive: false,
            item: entry,
        });
    }

    function calculateColumnNum() {
        if (!grid || items.length === 0) return 0;

        const styles = window.getComputedStyle(grid, null);
        const paddingLeft = parseFloat(styles.getPropertyValue('padding-left'));
        const paddingRight = parseFloat(
            styles.getPropertyValue('padding-right')
        );
        const gap = parseFloat(styles.getPropertyValue('gap'));
        const width = parseFloat(styles.getPropertyValue('width'));
        const availableWidth = width - (paddingLeft + paddingRight);

        const itemWidth = items[0].clientWidth;
        const canFitNoGap = Math.floor(availableWidth / itemWidth);
        const takenByGaps = (canFitNoGap - 1) * gap;
        return Math.floor((availableWidth - takenByGaps) / itemWidth);
    }

    async function handleScreenResize() {
        const currentColumnNum = calculateColumnNum();
        if (prevColNum === currentColumnNum) return;

        prevColNum = currentColumnNum;
        await syncState();
    }

    const resizeObserver = new ResizeObserver(handleScreenResize);
    resizeObserver.observe(grid);

    function getInsertPosition(idx: number, columns: number) {
        if (isNaN(columns)) {
            columns = 1;
        }
        while ((idx + 1) % columns !== 0) {
            idx++;
            if (idx > 50) {
                throw new Error(
                    'Infinite loop in the getInsertPosition method'
                );
            }
        }
        return Math.min(items.length - 1, idx);
    }

    async function syncState() {
        const currentIdx = entries.findIndex((e) => e.isActive === true);
        const columnNum = calculateColumnNum();
        items.forEach(item => item.removeAttribute('aria-selected'))

        const visibleItem = qs<HTMLLIElement>('[component-pic]', 'silent');

        if (visibleItem) {
            visibleItem.classList.remove('open');
            await wait(500);
            visibleItem.remove();
        }

        const duplicates = qsa<HTMLLIElement>('[component-pic]');

        duplicates.forEach((item) => item.remove());

        if (currentIdx === -1 || columnNum == null) return;

        const currentActiveItem = entries[currentIdx];

        const itemElement = generateItemHTML(currentActiveItem.item);

        if (itemElement == null) return;

        const insertPosition = getInsertPosition(currentIdx, columnNum);
        const newItem = items[insertPosition].insertAdjacentElement(
            'afterend',
            itemElement
        );

        if (newItem) {
            items[currentIdx].setAttribute('aria-selected', 'true');
            await wait(100);
            newItem.classList.add('open');
            await wait(500);
            newItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        initAdaptiveImages();
    }

    function updateState(id: number) {
        const currentActiveItem = entries.find((e) => e.isActive === true);

        if (currentActiveItem == null) {
            const item = entries.find((e) => e.id === id);

            if (item) {
                item.isActive = true;
            }
            return;
        }

        currentActiveItem.isActive = false;

        if (currentActiveItem.id === id) {
            return;
        }

        const item = entries.find((e) => e.id === id);

        if (item) {
            item.isActive = true;
        }
    }

    for (let i = 0; i < items.length; i++) {
        const item = items[i];
        const id = item.getAttribute('data-practice-item-id');
        const button = qs<HTMLButtonElement>(
            '[component-pic-button]',
            'error',
            item
        );

        if (!id) {
            throw new Error("Practice item doesn't have an id attribute");
        }

        button.addEventListener('click', async () => {
            updateState(Number(id));
            syncState();
        });
    }

    async function fetchAllItems() {
        const url = `/api/practice_items`;

        try {
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error(error);
        }
    }

    function generateItemHTML(item: ItemType) {
        const template = qs<HTMLTemplateElement>(
            '[component-pic-template]',
            'silent'
        );

        if (!template) return null;

        const clone = document.importNode(template.content, true);
        const wrapper = qs<HTMLLIElement>('[component-pic]', 'error', clone);

        const imgSrc = wrapper.getAttribute('data-img-src');
        const imgAlt = wrapper.getAttribute('data-img-alt');

        if (!imgSrc) {
            throw new Error(
                'Image source attribute is absent on the list item of the practice item template'
            );
        }
        wrapper.innerHTML = wrapper.innerHTML.replaceAll(imgSrc, item.img_src);

        if (imgAlt && item.img_alt) {
            wrapper.innerHTML = wrapper.innerHTML.replace(imgAlt, item.img_alt);
        }

        const title = qs<HTMLHeadingElement>(
            '[component-pic-title]',
            'error',
            wrapper
        );
        const description = qs<HTMLParagraphElement>(
            '[component-pic-description]',
            'error',
            wrapper
        );
        const fileLink = qs<HTMLAnchorElement>(
            '[component-file-link]',
            'error',
            wrapper
        );

        title.innerText = item.title;
        description.innerText = item.description;

        if (item.file) {
            fileLink.setAttribute('href', item.file);
        } else {
            fileLink.remove();
        }

        const faqWrapper = qs<HTMLParagraphElement>(
            '[component-pic-faqs]',
            'error',
            wrapper
        );

        if (item.faqs) {
            const faqs = JSON.parse(item.faqs);

            for (let j = 0; j < faqs.length; j++) {
                const faq = faqs[j];

                const [details, summary, p] = createElements([
                    'details',
                    'summary',
                    'p',
                ]);
                summary.textContent = `${j + 1}. ${faq.question}`;
                p.textContent = faq.answer;
                details.append(summary, p);
                details.setAttribute('name', 'faqs');
                faqWrapper.appendChild(details);
            }
        } else {
            faqWrapper.remove();
        }

        return wrapper;
    }
}
