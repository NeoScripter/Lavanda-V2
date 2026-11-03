import { qs } from '../utils';

const crossTabChannel = new BroadcastChannel('app-events');

export default function initSSE() {
    const evtSource = new EventSource('/sse', { withCredentials: true });

    evtSource.onopen = function () {
        console.log('Connection to server opened.');
    };

    evtSource.addEventListener('notification', function (e) {
        const data = e.data as string;

        crossTabChannel.postMessage({
            eventName: 'notification:show',
            data: data,
        });

        displayNotification(data);
    });

    evtSource.addEventListener('error', () => {
        console.log('EventSource failed.');
    });

    crossTabChannel.onmessage = (e) => {
        const { eventName, data } = e.data;

        if (eventName === 'notification:show') {
            displayNotification(data);
        }
    };

    function displayNotification(data: string) {
        console.log('works');
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
    }
}
