<?php

use Enums\GameType;

slot('layouts/web/app-layout', [
    'title' => 'Таблица гексаграмм',
]); ?>

<?php ob_start(); ?>
Таблица гексаграмм
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>«Книга Перемен» сопровождает китайскую философию почти три тысячи лет. Её не читают как обычную книгу — с ней советуются. Каждая гексаграмма предлагает не готовый ответ, а другой взгляд на происходящее, позволяя увидеть ситуацию шире.</p>
<p>Бросай три древние монеты и расшифруй свою гексаграмму</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => 'Перейти к игре',
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/iching/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>


<?php ob_start(); ?>
<div>
    <div cmp-visible-at-start
        class='mx-auto max-w-200 *:py-[0.5em]'>
        <h2 class="text-white text-2xl md:text-3xl lg:text-4xl">Правила</h2>
        <p>Суть метода работы с “Книгой Перемен” получить гексаграмму (набор из 6 линий) и изучить ее интерпретацию, которая часто даже очень точна по срокам.</p>
        <p>На данный момент самый распространенный вид получения гексаграммы – с монетами. Три монеты подбрасываются 6 раз, формируя гексаграмму.</p>
        <p>В нашем случае специальные алгоритмы воспроизводят работу с монетами, формируя последовательно гексаграмму. Затем Вы получаете трактование сформированной гексаграммы.</p>
        <p>Вы также можете самостоятельно оффлайн сформировать гексаграмму с помощью трех монет (можно древних или иногда советуют брать серебряные). А затем, по полученной гексаграмме, найти трактование на нашем уютном Лавандовом Пространстве.</p>
    </div>

    <!-- <div cmp-selected-items></div> -->
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <article cmp-game="<?= GameType::ICHING->value ?>"
        class="md:rounded-2xl shadow-[10px_10px_20px_#00000040,0_1.5px_1px_#e1d4ff_inset] space-y-(--space-y) backdrop-blur-sm bg-linear-[180deg,#c8b5ff42,#ffffff30] -mx-7 p-(--space-y) sm:-mx-9 py-14.5 -mb-14.5 md:mb-0 md:mx-auto max-w-280">

        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => 'Бросить монеты',
            'attrs' => [
                'cmp-launch-game-btn' => true,
                'cmp-visible-at-start' => true
            ],
            'class' => 'mx-auto'
        ]) ?>

        <ul class='space-y-6 md:space-y-8'>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <li class='flex items-center justify-between gap-6 xs:gap-10 md:gap-16 flex-wrap xs:flex-nowrap'>
                    <div class='p-4 w-full border border-white gap-4 md:p-6 md:gap-6 rounded-md flex items-center justify-center'>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                    </div>

                    <?= component('web/ui/flip-coin', [
                        'class' => 'size-20 md:size-30 flex-1 w-full -order-2 xs:order-0'
                    ]) ?>

                    <div class='p-4 w-full border border-white rounded-md md:p-6 md:gap-6 gap-4 flex items-center justify-center'>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                    </div>
                </li>

            <?php endfor; ?>
        </ul>

    </article>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    // 'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
