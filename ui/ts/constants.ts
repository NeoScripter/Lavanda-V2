export const EVENTS = {
    SHOW_MODAL: 'modal-show',
    HIDE_MODAL: 'modal-hide',
    START_GAME: 'start_game',
    END_GAME: 'end_game',
    START_SPIN: 'start_spin',
    END_SPIN: 'end_spin',
    SETUP_GAME: 'setup_game',
    RESET_GAME: 'reset_game',
};

export const DURATION = {
    MODAL_TRANSITION_MS: 300,
};

export const DISTANCE = {
    SWIPE_THRESHOLD: 50,
};

export const GAME_CATEGORY = {
    TAROT: 'tarot',
    METAPHORIC: 'metaphoric',
    LENORMAND: 'lenormand',
    MIND_GAMES: 'mind_games',
    RUNE: 'rune',
    STONE: 'stone',
    BONUS: 'bonus',
};

export const GAME_CATEGORY_MAP = {
    bonus: GAME_CATEGORY.BONUS,
    bonus_home: GAME_CATEGORY.BONUS,
    metaphoric: GAME_CATEGORY.METAPHORIC,
    tarot: GAME_CATEGORY.TAROT,
};

export type CategoryType = typeof GAME_CATEGORY_MAP;

export const HTML_TYPE = {
    ITEMS: 'items',
    PREVIEW: 'preview',
};

export const HTML_TYPE_MAP = {
    bonus: HTML_TYPE.ITEMS,
    bonus_home: HTML_TYPE.PREVIEW,
    metaphoric: HTML_TYPE.ITEMS,
    tarot: HTML_TYPE.ITEMS,
};

export type HtmlType = typeof HTML_TYPE_MAP;

export const ROUND_TYPE = {
    RANDOM_CARDS: 'random_cards',
};

export const ROUND_TYPE_MAP = {
    bonus: ROUND_TYPE.RANDOM_CARDS,
    bonus_home: ROUND_TYPE.RANDOM_CARDS,
    metaphoric: ROUND_TYPE.RANDOM_CARDS,
    tarot: ROUND_TYPE.RANDOM_CARDS,
};

export type RoundType = typeof ROUND_TYPE_MAP;

export const PICKER_TYPE = {
    ONE_CARD: 'ONE_CARD',
};

export const PICKER_TYPE_MAP = {
    bonus: PICKER_TYPE.ONE_CARD,
    bonus_home: PICKER_TYPE.ONE_CARD,
    metaphoric: PICKER_TYPE.ONE_CARD,
    tarot: PICKER_TYPE.ONE_CARD,
};

export type PickerType = typeof PICKER_TYPE_MAP;

export type GameInfo = {
    html: HtmlType[keyof HtmlType];
    category: CategoryType[keyof CategoryType];
    round: RoundType[keyof RoundType];
    picker: PickerType[keyof PickerType];
};
