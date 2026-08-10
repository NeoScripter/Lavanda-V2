import { DISTANCE } from '../constants';
import { qs, qsa, throttle } from '../utils';

export default function initHomeCarousel() {
    const slides = qsa<HTMLLIElement>('[component-home-carousel-slide]');

    if (slides.length === 0) return;

    const wrapper = qs<HTMLDivElement>('[component-home-carousel-wrapper]');
    const prevBtn = qs<HTMLButtonElement>(
        '[component-prev-button]',
        'error',
        wrapper
    );
    const nextBtn = qs<HTMLButtonElement>(
        '[component-next-button]',
        'error',
        wrapper
    );

    let currentSlideIdx = 0;
    const lastSlide = slides.length - 1;

    const showSlide = (idx: number) => {
        slides[idx].classList.remove('opacity-0');
    };

    const hideSlide = (idx: number) => {
        slides[idx].classList.add('opacity-0');
    };

    showSlide(currentSlideIdx);

    const showPrevSlide = () => {
        const prevSlideIdx =
            currentSlideIdx === 0 ? lastSlide : currentSlideIdx - 1;

        showSlide(prevSlideIdx);
        hideSlide(currentSlideIdx);

        currentSlideIdx = prevSlideIdx;
    };

    const showNextSlide = () => {
        const nextSlideIdx =
            currentSlideIdx === lastSlide ? 0 : currentSlideIdx + 1;

        showSlide(nextSlideIdx);
        hideSlide(currentSlideIdx);
        currentSlideIdx = nextSlideIdx;
    };

    const transitionDuration =
        parseFloat(getComputedStyle(slides[0]).transitionDuration) ?? 0;

    const throttledShowPrevSlide = throttle(
        showPrevSlide,
        transitionDuration * 1000
    );
    const throttledShowNextSlide = throttle(
        showNextSlide,
        transitionDuration * 1000
    );

    prevBtn.addEventListener('click', throttledShowPrevSlide);
    nextBtn.addEventListener('click', throttledShowNextSlide);

    let touchStartX: number | null = null;

    wrapper.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
    });

    wrapper.addEventListener('touchend', (e) => {
        if (touchStartX === null) return;

        const deltaX = e.changedTouches[0].clientX - touchStartX;

        if (Math.abs(deltaX) > DISTANCE.SWIPE_THRESHOLD) {
            e.preventDefault();

            if (deltaX < 0) {
                throttledShowPrevSlide();
            } else {
                throttledShowNextSlide();
            }
        }

        touchStartX = null;
    });
}
