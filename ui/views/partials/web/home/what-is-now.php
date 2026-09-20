<section>
    <h2>А что сейчас?</h2>
    <p class='text-center text-balance font-medium uppercase mb-[1.5em] text-primary text-xl md:text-3xl lg:text-4xl'>Сегодня...</p>

    <ul class='grid sm:grid-cols-2 gap-4 sm:grid-rows-2 lg:grid-cols-3 lg:grid-rows-1'>
        <?= component('web/ui/branch-item', [
            'title' => 'Можно',
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_1_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/what_is_now_1_fg',
            'words' => ['чувствовать', 'довериться', 'выдохнуть', 'остановиться', 'ошибаться', 'выбирать', 'не спешить', 'не знать ответа'],
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => 'Быть',
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_2_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/what_is_now_2_fg',
            'words' => ['услышанной', 'с поддержкой', 'наедине с собой', 'собой', 'понятой', 'в безопасности', 'настоящей', 'такой, какая ты есть'],
            'class' => 'sm:row-span-2 sm:self-center lg:self-auto lg:row-span-1'
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => 'Вместе',
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_3_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/what_is_now_3_fg',
            'words' => ['теплее', 'смелее', 'спокойнее', 'легче', 'с пониманием', 'находить ответы', 'делать следующий шаг', 'идти дальше'],
        ]) ?>
    </ul>
</section>
