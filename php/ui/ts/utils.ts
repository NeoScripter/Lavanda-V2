export function gid<T extends Element>(
    id: string,
    behavior: 'silent'
): T | null;

export function gid<T extends Element>(sid: string, behavior?: 'error'): T;

export function gid<T extends HTMLElement>(
    id: string,
    behavior = 'error'
): T | null {
    const element = document.getElementById(id);
    if (!element) {
        if (behavior === 'silent') {
            return null;
        }

        console.error(`Element with id '${id}' not found`);
        throw new Error();
    }
    return element as T;
}

export function qsa<T extends Element>(
    selector: string,
    parent: Element | Document = document
): NodeListOf<T> {
    const elements = parent.querySelectorAll<T>(selector);
    if (!elements) {
        console.error(`Could not find elements with '${selector}' selector`);
    }
    return elements;
}

export function qs<T extends Element>(
    selector: string,
    behavior: 'silent',
    parent?: Element | Document | DocumentFragment
): T | null;

export function qs<T extends Element>(
    selector: string,
    behavior?: 'error',
    parent?: Element | Document | DocumentFragment
): T;

export function qs<T extends Element>(
    selector: string,
    behavior: 'silent' | 'error' = 'error',
    parent: Element | Document | DocumentFragment = document
): T | null {
    const element = parent.querySelector<T>(selector);
    if (!element) {
        if (behavior === 'silent') {
            return null;
        }
        console.error(`Could not find an element with '${selector}' selector`);
        throw new Error();
    }
    return element;
}

export function setCookie(cname: string, cvalue: string, exdays = 30) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = 'expires=' + d.toUTCString();
    document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
}

export function getCookie(cname: string) {
    let name = cname + '=';
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}

export function debounce<T extends (...args: any[]) => any>(
    fn: T,
    delay: number
): (...args: Parameters<T>) => void {
    let timer: ReturnType<typeof setTimeout>;

    return function (this: any, ...args: Parameters<T>): void {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

export function throttle<T extends (...args: any[]) => any>(
    fn: T,
    delay: number = 400
): (...args: Parameters<T>) => void {
    let lastCall = 0;
    return function (this: ThisParameterType<T>, ...args: Parameters<T>) {
        const now = Date.now();
        if (now - lastCall >= delay) {
            lastCall = now;
            fn.apply(this, args);
        }
    };
}
