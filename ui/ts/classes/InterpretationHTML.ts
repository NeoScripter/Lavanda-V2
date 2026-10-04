import { createAdaptiveImg } from '../utils';
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

const LOREM = {
    NAME: 'Lorem ipsum dolor sit',
    THEME: 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
    ADVICE: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor.',
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

    public getLoader(): HTMLElement {
        switch (this.html_type) {
            case HTML_TYPE.ITEMS:
                return this.itemsLoader();
            case HTML_TYPE.PREVIEW:
                return this.previewLoader();
            default:
                throw new Error('Unknown interpretation html type');
        }
    }

    private items(data: InterpretationPayload) {
        const wrapper = document.createElement('ul');

        for (const item of data.items) {
            const li = document.createElement('li');

            const w1 = document.createElement('div');
            const img = createAdaptiveImg(item.img, item.alt);
            const name = document.createElement('h3');
            name.textContent = item.name;
            w1.append(name, img);

            const w2 = document.createElement('div');
            const theme = document.createElement('p');
            theme.textContent = item.themes[0]?.html ?? '';
            const advice = document.createElement('p');
            advice.textContent = item.advice;
            w2.append(theme, advice);

            li.append(w1, w2);

            wrapper.appendChild(li);
        }

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
        const game = qs<HTMLDivElement>('[cmp-game]');
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

    private previewLoader() {
        const wrapper = document.createElement('div');
        wrapper.classList.add('skeleton');

        const img = document.createElement('div');
        img.setAttribute('component-adaptive-image', '');
        wrapper.appendChild(img);

        for (let i = 0; i < 9; i++) {
            const p = document.createElement('p');
            p.textContent = LOREM.THEME;
            wrapper.appendChild(p);
        }
        wrapper.setAttribute('cmp-interpretation-preview', '');

        return wrapper;
    }

    private itemsLoader() {
        const wrapper = document.createElement('ul');
        wrapper.classList.add('skeleton');

        for (let i = 0; i < 4; i++) {
            const li = document.createElement('li');

            const w1 = document.createElement('div');
            const img = document.createElement('div');
            img.setAttribute('component-adaptive-image', '');
            const name = document.createElement('h3');
            name.textContent = LOREM.NAME;
            w1.append(name, img);

            const w2 = document.createElement('div');
            const theme = document.createElement('p');
            theme.textContent = LOREM.THEME;
            const advice = document.createElement('p');
            advice.textContent = LOREM.ADVICE;
            w2.append(theme, advice);

            li.append(w1, w2);

            wrapper.appendChild(li);
        }

        return wrapper;
    }
}
