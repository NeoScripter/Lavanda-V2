import { qs } from '../utils';
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

const GAME_CATEGORY = {
    TAROT: 'tarot',
    METAPHORIC: 'metaphoric',
    LENORMAND: 'lenormand',
    MIND_GAMES: 'mind_games',
    RUNE: 'rune',
    STONE: 'stone',
    BONUS: 'bonus',
};

const GAME_CATEGORY_MAP = {
    bonus: GAME_CATEGORY.BONUS,
    bonus_home: GAME_CATEGORY.BONUS,
};

type CategoryType = typeof GAME_CATEGORY_MAP;

export default class Interpretation {
    ids: string[];
    category: CategoryType[keyof CategoryType];
    elements: Elements;
    payload: InterpretationPayload | null;

    constructor(items: HTMLElement[]) {
        this.elements = {
            interpretation: qs<HTMLDivElement>('[cmp-interpretation]'),
        };
        this.ids = this.pluckIds(items);
        this.category = this.getCategory();
        this.payload = null;
    }

    public async show() {
        if (! this.payload) {
            const payload = await this.getPayload() as InterpretationPayload; 
            this.payload = payload;
        }
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
            return await response.json();
        } catch (error) {
            console.log(error);
        } finally {
            this.hideLoader();
        }
    }

    private displayLoader() {}
    private hideLoader() {}

    private getCategory() {
        const game = qs<HTMLDivElement>('[cmp-game]');
        const type = game.getAttribute('cmp-game');

        if (!type) {
            throw new Error("The game doesn't contain the cmp-game attribute");
        }

        if (!Object.keys(GAME_CATEGORY_MAP).includes(type)) {
            throw new Error('The game category is invalid');
        }

        const key = type as keyof CategoryType;
        return GAME_CATEGORY_MAP[key];
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
