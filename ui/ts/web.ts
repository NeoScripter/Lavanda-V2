import '../css/web.css';
import initStoneGame from './initializers/initStoneGame';
import initAdaptiveImages from './modules/adaptiveImages';
import initAffirmations from './modules/affirmations';
import initAudioPlayers from './modules/audioPlayers';
import initAudios from './modules/audios';
import initBranchItems from './modules/branchItems';
import initCardGrid from './modules/cardGrid';
import initCheckboxes from './modules/checkboxes';
import initGame from './initializers/initGame';
import initIchingGame from './initializers/initIchingGame';
import initLenormandPickers from './modules/lenormand';
import initModals from './modules/modals';
import initNavMenu from './modules/navMenu';
import initPlanetSpinner from './modules/planetSpinner';
import initPracticeItems from './modules/practiceItems';
import initRuneGrid from './modules/runeGrid';
import initToasts from './modules/toasts';
import initDiceGame from './modules/diceGame';

class WebUI {
    constructor() {
        this.bindEvents();
    }

    private bindEvents(): void {
        const handlers = [
            initModals,
            initToasts,
            initNavMenu,
            initCheckboxes,
            initAdaptiveImages,
            initPracticeItems,
            initGame,
            initCardGrid,
            initLenormandPickers,
            initBranchItems,
            initPlanetSpinner,
            initRuneGrid,
            initAffirmations,
            initAudioPlayers,
            initAudios,
            initIchingGame,
            initStoneGame,
            initDiceGame,
        ];

        for (const handler of handlers) {
            try {
                handler();
            } catch (error) {
                console.error(error);
            }
        }
    }
}

class App {
    ui: WebUI | null;
    constructor() {
        this.ui = null;
    }

    init() {
        try {
            this.ui = new WebUI();
            console.log('App initialized successfully');
        } catch (error) {
            console.error('Failed to initialize app:', error);
        }
    }
}

let app: App | null;

document.addEventListener('DOMContentLoaded', () => {
    app = new App();
    app.init();
});

window.addEventListener('load', () => {
    if (!app) {
        app = new App();
        app.init();
    }
});
