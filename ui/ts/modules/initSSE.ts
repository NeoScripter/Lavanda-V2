import { qs } from "../utils";

export default function initSSE() {
    const evtSource = new EventSource('/sse', { withCredentials: true });

    evtSource.onopen = function () {
        console.log('Connection to server opened.');
    };

    evtSource.addEventListener('subscribed', function (e) {
        const data = e.data as string;
        const sentences = data.split('|').filter((str) => str.trim() !== '');

        const notifications = qs<HTMLDivElement>('[cmp-notification]', 'silent');

        if (!notifications) return;

        const wrapper = qs<HTMLDivElement>('[cmp-notification-content]', 'error', notifications);

        wrapper.innerHTML = '';
        const frag = document.createDocumentFragment();

        for (const sentence of sentences) {
            const p = document.createElement('p');
            p.innerText = sentence;
            frag.appendChild(p);
        }

        wrapper.appendChild(frag);
        notifications.classList.add('shown');

        setTimeout(() => notifications.classList.remove('shown'), 5000);
    });

    evtSource.onerror = function () {
        console.log('EventSource failed.');
    };
}
