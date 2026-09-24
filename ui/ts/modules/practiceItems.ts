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

export default function initPracticeItems() {
    const grid = qs<HTMLUListElement>('[component-practice-grid]', 'silent');

    const items = qsa<HTMLLIElement>('[data-practice-item-id]');
    const cache = new Map();
    let prevItemId: string | null = null;

    if (!grid) return;

    for (const item of items) {
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
            const url = `/api/practice_items/${id}`;

            let data;
            try {
                const response = await fetch(url);
                data = await response.json();
            } catch (error) {
                console.error(error);
            }
            let itemElement;

            if (prevItemId == id) {
                cache.get(id).remove();
                prevItemId = null;
                return;
            }

            if (cache.has(id)) {
                itemElement = cache.get(id);
            } else {
                itemElement = createItemElement(data);
            }

            if (!itemElement) return;

            if (prevItemId != null) {
                cache.get(prevItemId).remove();
            }
            prevItemId = id;

            const newItem = item.insertAdjacentElement('afterend', itemElement);

            if (!cache.has(id)) {
                initAdaptiveImages();
                cache.set(id, newItem);
            }
        });
    }

    function createItemElement(item: ItemType) {
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
