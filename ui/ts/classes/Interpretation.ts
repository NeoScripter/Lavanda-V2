import initAdaptiveImages from '../modules/adaptiveImages';
import { qs, wait } from '../utils';
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
    items: HTMLElement[];
    category: CategoryType[keyof CategoryType];
    elements: Elements;
    payload: InterpretationPayload | null;
    html: InterpretationHTML;

    constructor(items: HTMLElement[]) {
        this.elements = {
            interpretation: qs<HTMLDivElement>('[cmp-interpretation]'),
        };
        this.items = items;
        this.category = this.getCategory();
        this.payload = null;
        this.html = new InterpretationHTML();
    }

    public async show() {
        if (!this.payload) {
            const payload = (await this.getPayload()) as InterpretationPayload;
            this.payload = payload;
        }
        const html = this.html.generate(this.payload);
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

    public async getPayload() {
        const API_URL = '/api/interpretation';
        const queryParams = {
            ids: this.pluckItemsIds().join(','),
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

    private displayLoader() {
        const loader = this.html.getLoader();
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

    private pluckItemsIds() {
        return this.items.map((item) => {
            const id = item.getAttribute('data-id');

            if (!id) {
                throw new Error("item doesn't have an id");
            }

            return id;
        });
    }
}
