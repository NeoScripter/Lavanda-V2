import { createElements, qs, qsa } from '../utils';
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

// TODO: 2 Add animation
// TODO: 3 Add slide active state
// TODO: 4 Add resize observer logic
// TODO: 5 Add loading state for fetch

export default async function initPracticeItems() {
    const grid = qs<HTMLUListElement>('[component-practice-grid]', 'silent');

    const items = qsa<HTMLLIElement>('[data-practice-item-id]');
    // <= 931 = 1
    // <= 1664 = 2
    // > 1664 = 3

    if (!grid) return;

    const payload = await fetchAllItems();
    const entries: Entry[] = [];

    for (const entry of payload) {
        entries.push({
            id: entry.id,
            isActive: false,
            item: entry,
        });
    }

    function getInsertPosition(idx: number) {
        const windowWidth = window.innerWidth;
        if (windowWidth > 1664) {
            while ((idx + 1) % 3 !== 0) {
                idx++;
            }
        } else if (windowWidth > 1535) {
            while ((idx + 1) % 2 !== 0) {
                idx++;
            }
        } else if (windowWidth > 1380) {
            while ((idx + 1) % 3 !== 0) {
                idx++;
            }
        } else if (windowWidth > 931) {
            while ((idx + 1) % 2 !== 0) {
                idx++;
            }
        }
        return Math.min(items.length - 1, idx);
    }

    function syncState(currentIdx: number) {
        const currentActiveItem = entries.find((e) => e.isActive === true);

        qs<HTMLLIElement>('[component-pic]', 'silent')?.remove();

        if (currentActiveItem == null) return;

        const itemElement = generateItemHTML(currentActiveItem.item);

        if (itemElement == null) return;

        const insertPosition = getInsertPosition(currentIdx);
        items[insertPosition].insertAdjacentElement('afterend', itemElement);
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
            syncState(i);
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

            for (const faq of faqs) {
                const [details, summary, p] = createElements([
                    'details',
                    'summary',
                    'p',
                ]);
                summary.textContent = faq.question;
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
