import { cloneAttributes, createAdaptiveImg, qsa, selectFirstVisibleElement } from '../utils';
import { qs } from '../utils';
import type { InterpretationPayload } from './Interpretation';

const HTML_TYPE = {
    ITEMS: 'items',
    PREVIEW: 'preview',
};

const HTML_TYPE_MAP = {
    bonus: HTML_TYPE.ITEMS,
    bonus_home: HTML_TYPE.PREVIEW,
};

type HtmlType = typeof HTML_TYPE_MAP;

export default class InterpretationHTML {
    html_type: HtmlType[keyof HtmlType];

    constructor() {
        this.html_type = this.getHtmlType();
    }

    public generate(payload: InterpretationPayload): HTMLElement {
        switch (this.html_type) {
            case HTML_TYPE.ITEMS:
                return this.items(payload);
            case HTML_TYPE.PREVIEW:
                return this.preview(payload);
            default:
                throw new Error('Unknown interpretation html type');
        }
    }

    public convertToLoader(element: HTMLElement): HTMLElement {
        element.classList.add('skeleton');

        const images = qsa<HTMLDivElement>(
            '[component-adaptive-image]',
            element
        );

        images.forEach((img) => {
            const div = document.createElement('div');
            cloneAttributes(div, img)
            div.setAttribute('component-adaptive-image', '');
            img.replaceWith(div);
        });

        const paragraphs = qsa<HTMLParagraphElement>('p', element);

        paragraphs.forEach((paragraph) => {
            const div = document.createElement('div');
            cloneAttributes(div, paragraph)

            for (let i = 0; i < 6; i++) {
                const p = document.createElement('p');
                p.textContent = paragraph.textContent;
                div.appendChild(p);
            }

            paragraph.replaceWith(div);
        });

        return element;
    }

    private items(data: InterpretationPayload) {
        const wrapper = document.createElement('ul');
        wrapper.setAttribute('cmp-interpretation-items', '');

        const children = [];

        for (const item of data.items) {
            const li = document.createElement('li');

            const w1 = document.createElement('div');
            w1.classList.add('headline');
            const img = createAdaptiveImg(item.img, item.alt);
            const name = document.createElement('h3');
            name.textContent = item.name;
            w1.append(name, img);

            const w2 = document.createElement('div');
            w2.classList.add('content');
            const theme = document.createElement('p');
            theme.textContent = item.themes[0]?.html ?? '';
            const advice = document.createElement('p');
            advice.textContent = item.advice;
            advice.classList.add('advice');
            w2.append(theme, advice);

            li.append(w1, w2);

            const hr = document.createElement('hr');

            children.push(li, hr);
        }

        children.pop();
        wrapper.append(...children);

        return wrapper;
    }

    private preview(data: InterpretationPayload) {
        const wrapper = document.createElement('div');

        if (data.items.length === 0) return wrapper;

        const item = data.items[0];
        const p = document.createElement('p');
        p.textContent = item.themes[0]?.html;
        const img = createAdaptiveImg(item.img, item.alt);
        wrapper.appendChild(img);
        wrapper.appendChild(p);
        wrapper.setAttribute('cmp-interpretation-preview', '');

        return wrapper;
    }

    private getHtmlType() {
        const game = selectFirstVisibleElement<HTMLDivElement>('[cmp-game]');
        const type = game.getAttribute('cmp-game');

        if (!type) {
            throw new Error("The game doesn't contain the cmp-game attribute");
        }

        if (!Object.keys(HTML_TYPE_MAP).includes(type)) {
            throw new Error('The game type is invalid');
        }

        const key = type as keyof HtmlType;
        return HTML_TYPE_MAP[key];
    }
}
