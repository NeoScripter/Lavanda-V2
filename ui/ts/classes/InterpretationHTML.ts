import { createAdaptiveImg } from '../utils';
import { qs } from '../utils';
import type { InterpretationPayload } from './Interpretation';

const HTML_TYPE = {
    BONUS: 'bonus',
    BONUS_HOME: 'bonus_home',
}

type HtmlType = typeof HTML_TYPE;

export default class InterpretationHTML {
    html_type: HtmlType[keyof HtmlType];

    constructor() {
        const attr = qs<HTMLDivElement>('[cmp-interpretation]').getAttribute('data-html-type');

        if (! attr) {
            throw new Error("Component interpretation doesn't include data-html-type");
        }

        if (! Object.values(HTML_TYPE).includes(attr)) {
            throw new Error("data-html-type contains invalid attribute");
        }

        this.html_type = attr;
        
    }

    public generate(payload: InterpretationPayload): HTMLElement {
        switch (this.html_type) {
            case HTML_TYPE.BONUS: return this.bonus(payload);
            case HTML_TYPE.BONUS_HOME: return this.bonus_home(payload);
            default: throw new Error('Unknown interpretation html type');
        }

    }

    private bonus(data: InterpretationPayload) {
        const wrapper = document.createElement('ul');
        const item = document.createElement('li');

        const w1 = document.createElement('div');
        const img = createAdaptiveImg(data.img, data.alt);
        const name = document.createElement('h3');
        name.textContent = data.title;
        w1.append(name, img);

        const w2 = document.createElement('div');
        const theme = document.createElement('p');
        theme.textContent = data.theme;
        const advice = document.createElement('p');
        advice.textContent = data.advice;
        w2.append(theme, advice);

        item.append(w1, w2);

        wrapper.appendChild(item);

        return wrapper;
    }

    private bonus_home(data: InterpretationPayload) {
        const wrapper = document.createElement('div');
        const p = document.createElement('p');
        p.textContent = data.theme;
        const img = createAdaptiveImg(data.img, data.alt);
        wrapper.appendChild(img);
        wrapper.appendChild(p);

        return wrapper;
    }
}
