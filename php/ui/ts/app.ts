import '../css/app.css';
import initAccountMenu from './modules/accountMenu';
import initAdaptiveImages from './modules/adaptiveImages';
import initCheckboxes from './modules/checkboxes';
import initDraggableReports from './modules/draggableReports';
import filePond from './modules/filePond';
import initScrollToInputError from './modules/inputErrors';
import initModals from './modules/modals';
import initPasswordInputButtons from './modules/passwordInputButtons';
import initSidebar from './modules/sidebar';
import theme from './modules/theme';
import initToasts from './modules/toasts';
import initWysiwygs from './modules/wysiwygs';

class AppUI {
    constructor() {
        this.bindEvents();
    }

    private bindEvents(): void {
        const handlers = [
            theme,
            filePond,
            initModals,
            initToasts,
            initCheckboxes,
            initSidebar,
            initAdaptiveImages,
            initAccountMenu,
            initScrollToInputError,
            initPasswordInputButtons,
            initWysiwygs,
            initDraggableReports,
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
    ui: AppUI | null;
    constructor() {
        this.ui = null;
    }

    init() {
        try {
            this.ui = new AppUI();
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
