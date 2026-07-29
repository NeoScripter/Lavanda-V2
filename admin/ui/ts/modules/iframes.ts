import { EVENTS } from '../constants';
import { qs, qsa } from '../utils';

export default function initIframes() {
    document.addEventListener(EVENTS.SHOW_MODAL, () => {
        const iframes = qsa<HTMLDivElement>('[component-iframe-wrapper]');

        if (iframes.length === 0) return;

        for (const wrapper of iframes) {
            const videoSrc = wrapper.getAttribute('data-video-src');

            if (!videoSrc) {
                throw new Error(
                    'No video source provided to the iframe parent'
                );
            }

            const preview = qs<HTMLDivElement>(
                '[component-iframe]',
                'error',
                wrapper
            );
            const trigger = qs<HTMLButtonElement>(
                '[component-iframe-trigger]',
                'error',
                wrapper
            );

            trigger.addEventListener(
                'click',
                () => {
                    const iframe = document.createElement('iframe');
                    iframe.setAttribute('src', videoSrc);
                    iframe.classList.add(
                        'size-full',
                        'object-cover',
                        'object-center'
                    );
                    iframe.setAttribute('allowfullscreen', '');
                    wrapper.appendChild(iframe);
                    preview.classList.add('hidden');
                },
                { once: true }
            );
        }
    });
}
