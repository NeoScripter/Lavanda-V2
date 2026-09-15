import { DISTANCE, DURATION } from '../constants';
import { qs, qsa, throttle } from '../utils';

export default function initGallery() {
    const triggers = qsa<HTMLButtonElement>('[component-gallery-trigger]');

    const showGalleryModal = () => {
        const gallery = qs<HTMLDivElement>('[component-gallery-modal]');

        const rawImgData = gallery.getAttribute('data-images');

        if (!rawImgData) {
            throw new Error('Image data is not found');
        }

        const parsedImgData = JSON.parse(rawImgData) as string[];

        const image = qs<HTMLImageElement>(
            '[component-image]',
            'error',
            gallery
        );
        const imageSrc = image.getAttribute('src');

        if (!imageSrc) {
            throw new Error("Image element doesn't contain the src attribute");
        }

        let currentIdx = parsedImgData.findIndex((src) =>
            imageSrc.startsWith(src)
        );
        const totalImages = parsedImgData.length;

        const prevBtn = qs<HTMLButtonElement>(
            '[component-prev-btn]',
            'error',
            gallery
        );
        const nextBtn = qs<HTMLButtonElement>(
            '[component-next-btn]',
            'error',
            gallery
        );

        let locked = false;

        function scrollNext() {
            if (locked) return;
            locked = true;

            if (currentIdx === totalImages - 1) {
                currentIdx = 0;
            } else {
                currentIdx++;
            }
            updateImageSrc();
        }

        function scrollPrev() {
            if (locked) return;
            locked = true;

            if (currentIdx === 0) {
                currentIdx = totalImages - 1;
            } else {
                currentIdx--;
            }
            updateImageSrc();
        }

        function updateImageSrc() {
            const newImageSrc = parsedImgData[currentIdx];
            image.classList.add('scale-0', 'opacity-0');
            setTimeout(() => {
                image.setAttribute('src', newImageSrc + '-dk.webp');
                image.classList.remove('scale-0', 'opacity-0');
                setTimeout(() => (locked = false), 500);
            }, 500);
        }

        prevBtn.addEventListener('click', scrollPrev);
        nextBtn.addEventListener('click', scrollNext);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') {
                scrollPrev();
            } else if (e.key === 'ArrowLeft') {
                scrollNext();
            }
        });

        let touchStartX: number | null = null;

        gallery.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        });

        gallery.addEventListener('touchend', (e) => {
            if (touchStartX === null) return;

            const deltaX = e.changedTouches[0].clientX - touchStartX;

            if (Math.abs(deltaX) > DISTANCE.SWIPE_THRESHOLD) {
                e.preventDefault();

                if (deltaX < 0) {
                    scrollPrev();
                } else {
                    scrollNext();
                }
            }

            touchStartX = null;
        });
    };

    for (const trigger of triggers) {
        trigger.addEventListener('click', () => {
            setTimeout(showGalleryModal, DURATION.MODAL_TRANSITION_MS);
        });
    }

    // Code for adjusting gallery items' size based on the screen size
    const galleries = qsa<HTMLUListElement>('[component-gallery]');

    const adjustSlides = (wrapper: HTMLUListElement) => {
        const gap = parseFloat(getComputedStyle(wrapper).gap) ?? 0;

        const wrapperWidth = wrapper.getBoundingClientRect().width;

        const row = [];

        for (const li of qsa<HTMLLIElement>('li', wrapper)) {
            li.style.maxWidth = '';

            const taken = row.reduce(
                (acc, item) => acc + item.getBoundingClientRect().width,
                0
            );
            const gaps = row.length * gap;

            const itemWidth = li.offsetWidth;
            const spaceLeft = wrapperWidth - taken - gaps;

            if (spaceLeft < itemWidth) {
                row.push(li);
                const delta = (itemWidth - spaceLeft + 1) / row.length;

                row.forEach((slide) => {
                    const w = slide.offsetWidth;
                    slide.style.maxWidth = `${(w - delta).toFixed(2)}px`;
                });

                row.length = 0;
                continue;
            }
            row.push(li);
        }
    };

    const resizeObserver = new ResizeObserver((entries) => {
        for (const entry of entries) {
            adjustSlides(entry.target as HTMLUListElement);
        }
    });

    for (const wrapper of galleries) {
        resizeObserver.observe(wrapper);

        adjustSlides(wrapper);
    }
}
