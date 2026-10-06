import {
    GAME_CATEGORY_MAP,
    type CategoryType,
    type GameInfo,
} from '../constants';
import initAdaptiveImages from '../modules/adaptiveImages';
import { qs, selectFirstVisibleElement } from '../utils';
import InterpretationHTML from './InterpretationHTML';

type Elements = {
    interpretation: HTMLDivElement;
};

export type InterpretationPayload = {
    items: {
        id: number;
        name: string;
        img: string;
        alt: string;
        advice: string;
        themes: {
            id: number;
            name: string;
            themeable_type: string;
            themeable_id: number;
            html: string;
        }[];
    }[];
    match_sets: {
        id: number;
        matcheable_id: string;
        matcheable_type: string;
        html: string;
    }[];
};

const LOREM = {
    NAME: 'Lorem ipsum dolor sit',
    THEME: 'Lorem ipsum dolor sit amet',
    ADVICE: 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor.',
};

const SKELETON_PAYLOAD: InterpretationPayload = {
    items: [
        {
            id: 1,
            name: LOREM.NAME,
            img: 'lorem',
            alt: 'lorem',
            advice: LOREM.THEME,
            themes: [
                {
                    id: 1,
                    name: 'theme',
                    themeable_type: 'theme',
                    themeable_id: 1,
                    html: LOREM.THEME,
                },
            ],
        },
    ],
    match_sets: [],
};

export default class Interpretation {
    elements: Elements;
    payload: InterpretationPayload | null;
    html: InterpretationHTML;

    constructor(container: HTMLDivElement) {
        this.elements = {
            interpretation: container,
        };
        this.payload = null;
        this.html = new InterpretationHTML();
    }

    public async show(items: HTMLElement[], info: GameInfo) {
        if (!this.payload) {
            const payload = (await this.getPayload(
                items,
                info
            )) as InterpretationPayload;
            this.payload = payload;
        }
        const html = this.html.generate(this.payload, info);
        this.elements.interpretation.appendChild(html);
        this.elements.interpretation.classList.remove('hidden');
        this.elements.interpretation.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });
        initAdaptiveImages();
    }

    public reset() {
        this.elements.interpretation.innerHTML = '';
        this.elements.interpretation.classList.add('hidden');
        this.payload = null;
    }

    public async getPayload(items: HTMLElement[], info: GameInfo) {
        const ids = items.map((item) => {
            const id = item.getAttribute('data-id');

            if (!id) {
                throw new Error("item doesn't have an id");
            }

            return id;
        });

        const API_URL = '/api/interpretation';
        const queryParams = {
            ids: ids.join(','),
            category: info.category,
        };

        this.displayLoader(info);

        try {
            const queryString = new URLSearchParams(queryParams).toString();
            const url = `${API_URL}?${queryString}`;

            // await wait(2000);
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.log(error);
        } finally {
            this.hideLoader();
        }
    }

    private displayLoader(info: GameInfo) {
        const loader = this.html.convertToLoader(
            this.html.generate(SKELETON_PAYLOAD, info)
        );
        this.elements.interpretation.classList.remove('hidden');
        this.elements.interpretation.appendChild(loader);
        this.elements.interpretation.scrollIntoView({
            block: 'center',
            behavior: 'smooth',
        });
    }

    private hideLoader() {
        this.elements.interpretation.innerHTML = '';
    }
}
