import '../css/web.css';
import initAdaptiveImages from './modules/adaptiveImages';
import initCheckboxes from './modules/checkboxes';
import initModals from './modules/modals';
import initNavMenu from './modules/navMenu';
import initPracticeItems from './modules/practiceItems';
import initToasts from './modules/toasts';

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
            console.log('App ialized successfully');
        } catch (error) {
            console.error('Failed to ialize app:', error);
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
