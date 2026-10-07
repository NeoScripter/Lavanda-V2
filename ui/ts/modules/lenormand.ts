import { EVENTS } from "../constants";
import { qsa } from "../utils";

export default function initLenormandPickers() {
    const btns = qsa<HTMLButtonElement>('[cmp-selected-lenormand]');

    for (const btn of btns) {
        btn.addEventListener('click', () => {
            btns.forEach(button => button.removeAttribute('aria-selected'));
            btn.setAttribute('aria-selected', 'true');

            window.dispatchEvent(new CustomEvent(EVENTS.RESET_GAME))
        });
    }
}
