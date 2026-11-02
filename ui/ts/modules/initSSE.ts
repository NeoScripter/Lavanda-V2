import { qs } from '../utils';

export default function initSSE() {
    return;
    // const evtSource = new EventSource('/sse', { withCredentials: true });
    const evtSource = new EventSource('/sse', { withCredentials: true });
    // const evtSource = new EventSource('sse.php', { withCredentials: true });

    evtSource.onopen = function () {
        console.log('Connection to server opened.');
    };
    // evtSource.addEventListener('message', (e) => {
    //     console.log(e.data);
    // });

    evtSource.addEventListener('subscribed', function (e) {
        const data = e.data as string;
        console.log(data);
        return;
        const sentences = data.split('|').filter((str) => str.trim() !== '');

        const notifications = qs<HTMLDivElement>(
            '[cmp-notification]',
            'silent'
        );

        if (!notifications) return;

        const wrapper = qs<HTMLDivElement>(
            '[cmp-notification-content]',
            'error',
            notifications
        );

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

    evtSource.addEventListener('error', (e) => {
        if (e.readyState == EventSource.CLOSED) {
            console.log('Connection was closed', e);
        } else {
            console.log('EventSource failed.', e);
        }
    });
}
