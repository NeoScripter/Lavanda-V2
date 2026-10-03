import { qs } from '../utils';
import InterpretationHTML from './InterpretationHTML';

type Elements = {
    interpretation: HTMLDivElement;
};

export type InterpretationPayload = {

};

export default class Interpretation {
    ids: string[];
    category: string;
    elements: Elements;
    payload: InterpretationPayload;

    constructor(items: HTMLElement[], category: string) {
        this.ids = items.map((item) => {
            const id = item.getAttribute('data-id');

            if (!id) {
                throw new Error("item doesn't have an id");
            }

            return id;
        });

        this.category = category;
        this.payload = this.getPayload();
        this.elements = {
            interpretation: qs<HTMLDivElement>('[cmp-interpretation]'),
        };
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
}
