import { HTML_TYPE, type GameInfo } from '../constants';
import { cloneAttributes, createAdaptiveImg, qs, qsa } from '../utils';
import type { InterpretationPayload } from './Interpretation';

export default class InterpretationHTML {
    public generate(
        payload: InterpretationPayload,
        info: GameInfo
    ): HTMLElement | null {
        switch (info.html) {
            case HTML_TYPE.ITEMS:
                return this.items(payload);
            case HTML_TYPE.PREVIEW:
                return this.preview(payload);
            case HTML_TYPE.EMPTY:
                return this.empty();
            default:
                throw new Error('Unknown interpretation html type');
        }
    }

    public convertToLoader(element: HTMLElement | null): HTMLElement | null {

        if (!element) return null;

        element.classList.add('skeleton');

        const images = qsa<HTMLDivElement>(
            '[component-adaptive-image]',
            element
        );

        images.forEach((img) => {
            const div = document.createElement('div');
            cloneAttributes(div, img);
            div.setAttribute('component-adaptive-image', '');
            img.replaceWith(div);
        });

        const paragraphs = qsa<HTMLParagraphElement>('p', element);

        paragraphs.forEach((paragraph) => {
            const div = document.createElement('div');
            cloneAttributes(div, paragraph);

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

        if (data.items.length === 0) return wrapper;

        wrapper.setAttribute('cmp-interpretation-items', '');

        const children = [];

        if (data.items.some((item) => item.themes.length > 1)) {
            const template = qs<HTMLTemplateElement>(
                '[cmp-theme-picker]',
                'error'
            );

            const picker = document.importNode(template.content, true);
            const button = qs<HTMLButtonElement>(
                '[cmp-theme-btn]',
                'error',
                picker
            );
            const nav = qs<HTMLDivElement>('nav', 'error', picker);

            const unique = [
                ...new Set(
                    data.items.flatMap((item) =>
                        item.themes.map((theme) =>
                            theme.name.toLowerCase().trim()
                        )
                    )
                ),
            ].toSorted();

            button.textContent = unique.splice(0, 1)[0];
            button.setAttribute('selected-theme', '');

            for (const theme of unique) {
                const btnCopy = button.cloneNode(true) as HTMLButtonElement;
                btnCopy.removeAttribute('selected-theme');

                btnCopy.textContent = theme;

                nav.appendChild(btnCopy);
            }

            for (const btn of qsa<HTMLButtonElement>('[cmp-theme-btn]', nav)) {
                btn.addEventListener('click', () => {
                    const key = btn.textContent;

                    const nodes = qsa<HTMLLIElement>('li', wrapper);

                    for (let i = 0; i < data.items.length; i++) {
                        const theme = data.items[i].themes.find(
                            (theme) => theme.name.toLowerCase() === key.toLowerCase()
                        );

                        if (!theme) continue;

                        const node = nodes[i];
                        qs<HTMLParagraphElement>(
                            '*.theme>p',
                            'error',
                            node
                        ).textContent = theme.html;
                    }
                    qsa<HTMLButtonElement>('[cmp-theme-btn]', nav).forEach(
                        (button) => button.removeAttribute('selected-theme')
                    );
                    btn.setAttribute('selected-theme', '');
                });
            }
            children.push(picker);
        }

        for (const item of data.items) {
            const li = document.createElement('li');

            const w1 = document.createElement('div');
            w1.classList.add('headline');
            const img = createAdaptiveImg(item.img, item.alt);
            const name = document.createElement('h3');
            name.textContent = item.name;
            w1.append(name, img);

            const w2 = document.createElement('div');
            w2.classList.add('theme');
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

    private empty() {
        return null;
    }
}
