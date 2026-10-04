import { qs } from '../utils';
import InterpretationHTML from './InterpretationHTML';

type Elements = {
    interpretation: HTMLDivElement;
    game: HTMLDivElement;
};

export type InterpretationPayload = {};

const HTML_TYPE = {
    ITEMS: 'items',
};

const HTML_TYPE_MAP = {
    bonus: HTML_TYPE.ITEMS,
    bonus_home: HTML_TYPE.ITEMS,
};

type HtmlType = typeof HTML_TYPE_MAP;

export default class Interpretation {
    ids: string[];
    category: string;
    elements: Elements;
    payload: InterpretationPayload;
    htmlType: HtmlType[keyof HtmlType];

    constructor(items: HTMLElement[], category: string) {
        this.elements = {
            interpretation: qs<HTMLDivElement>('[cmp-interpretation]'),
            game: qs<HTMLDivElement>('[cmp-game]'),
        };
        this.ids = this.pluckIds(items);
        this.category = category;
        this.payload = this.getPayload();
        this.htmlType = this.getHtmlType();
    }

    public show() {
        const html = new InterpretationHTML().generate(this.payload);
        this.elements.interpretation.appendChild(html);
    }

    public reset() {
        this.elements.interpretation.innerHTML = '';
    }

    public async getPayload() {
        const API_URL = '/api/interpretation';
        const queryParams = {
            ids: this.ids.join(','),
            category: this.category,
        };

        this.displayLoader();

        try {
            const queryString = new URLSearchParams(queryParams).toString();
            const url = `${API_URL}?${queryString}`;

            const response = await fetch(url);
            this.payload = await response.json();
        } catch (error) {
            console.log(error);
        } finally {
            this.hideLoader();
        }
    }

    private displayLoader() {}
    private hideLoader() {}

    private getHtmlType() {
        const type = this.elements.game.getAttribute('cmp-game');

        if (!type) {
            throw new Error("The game doesn't contain the cmp-game attribute");
        }

        if (!Object.keys(HTML_TYPE_MAP).includes(type)) {
            throw new Error('The game type is invalid');
        }

        const key = type as keyof HtmlType;
        return HTML_TYPE_MAP[key];
    }

    private pluckIds(items: HTMLElement[]) {
        return items.map((item) => {
            const id = item.getAttribute('data-id');

            if (!id) {
                throw new Error("item doesn't have an id");
            }

            return id;
        });
    }
}
