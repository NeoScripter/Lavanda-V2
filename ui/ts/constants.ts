export const EVENTS = {
    SHOW_MODAL: 'modal-show',
    HIDE_MODAL: 'modal-hide',
    RESET_GAME: 'reset_game',
    SHUFFLE_RUNES: 'shuffle_runes',
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
    MINORI: 'minori',
};

export const GAME_CATEGORY_MAP = {
    bonus: GAME_CATEGORY.BONUS,
    minori: GAME_CATEGORY.MINORI,
    bonus_home: GAME_CATEGORY.BONUS,
    metaphoric: GAME_CATEGORY.METAPHORIC,
    tarot: GAME_CATEGORY.TAROT,
    mind_games: GAME_CATEGORY.MIND_GAMES,
    lenormand: GAME_CATEGORY.LENORMAND,
    rune: GAME_CATEGORY.RUNE,
    stone: GAME_CATEGORY.STONE,
};

export type CategoryType = typeof GAME_CATEGORY_MAP;

export const HTML_TYPE = {
    ITEMS: 'items',
    PREVIEW: 'preview',
    EMPTY: 'empty',
    STONE: 'stone',
};

export const HTML_TYPE_MAP = {
    bonus: HTML_TYPE.ITEMS,
    minori: HTML_TYPE.ITEMS,
    bonus_home: HTML_TYPE.PREVIEW,
    metaphoric: HTML_TYPE.ITEMS,
    tarot: HTML_TYPE.ITEMS,
    mind_games: HTML_TYPE.EMPTY,
    lenormand: HTML_TYPE.ITEMS,
    rune: HTML_TYPE.ITEMS,
    stone: HTML_TYPE.STONE,
};

export type HtmlType = typeof HTML_TYPE_MAP;

export const ROUND_TYPE = {
    RANDOM_CARDS: 'random_cards',
    LENORMAND: 'lenormand',
    RUNE: 'rune',
    STONE: 'stone',
};

export const ROUND_TYPE_MAP = {
    bonus: ROUND_TYPE.RANDOM_CARDS,
    minori: ROUND_TYPE.RANDOM_CARDS,
    bonus_home: ROUND_TYPE.RANDOM_CARDS,
    metaphoric: ROUND_TYPE.RANDOM_CARDS,
    tarot: ROUND_TYPE.RANDOM_CARDS,
    mind_games: ROUND_TYPE.RANDOM_CARDS,
    lenormand: ROUND_TYPE.LENORMAND,
    rune: ROUND_TYPE.RUNE,
    stone: ROUND_TYPE.STONE,
};

export type RoundType = typeof ROUND_TYPE_MAP;

export const PICKER_TYPE = {
    ONE_CARD: 'ONE_CARD',
    ONE_RUNE: 'ONE_RUNE',
    ONE_STONE: 'ONE_STONE',
};

export const PICKER_TYPE_MAP = {
    bonus: PICKER_TYPE.ONE_CARD,
    minori: PICKER_TYPE.ONE_CARD,
    bonus_home: PICKER_TYPE.ONE_CARD,
    metaphoric: PICKER_TYPE.ONE_CARD,
    tarot: PICKER_TYPE.ONE_CARD,
    mind_games: PICKER_TYPE.ONE_CARD,
    lenormand: PICKER_TYPE.ONE_CARD,
    rune: PICKER_TYPE.ONE_RUNE,
    stone: PICKER_TYPE.ONE_STONE,
};

export type PickerType = typeof PICKER_TYPE_MAP;

export type GameInfo = {
    html: HtmlType[keyof HtmlType];
    category: CategoryType[keyof CategoryType];
    round: RoundType[keyof RoundType];
    picker: PickerType[keyof PickerType];
};
