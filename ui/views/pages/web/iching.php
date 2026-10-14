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
<div cmp-iching-game class="group">
    <div cmp-visible-at-start
        class='mx-auto max-w-200 *:py-[0.5em]'>
        <h2 class="text-white text-2xl md:text-3xl lg:text-4xl">Правила</h2>
        <p>Суть метода работы с “Книгой Перемен” получить гексаграмму (набор из 6 линий) и изучить ее интерпретацию, которая часто даже очень точна по срокам.</p>
        <p>На данный момент самый распространенный вид получения гексаграммы – с монетами. Три монеты подбрасываются 6 раз, формируя гексаграмму.</p>
        <p>В нашем случае специальные алгоритмы воспроизводят работу с монетами, формируя последовательно гексаграмму. Затем Вы получаете трактование сформированной гексаграммы.</p>
        <p>Вы также можете самостоятельно оффлайн сформировать гексаграмму с помощью трех монет (можно древних или иногда советуют брать серебряные). А затем, по полученной гексаграмме, найти трактование на нашем уютном Лавандовом Пространстве.</p>
    </div>


    <article
        cmp-visible-at-end
        class='flex flex-col items-center group-has-[[cmp-skeleton]]:hidden gap-4 md:flex-row md:items-start md:gap-[calc(var(--space-y)*1.5)] pb-(--space-y) lg:py-[calc(var(--space-y)/2)] mx-auto max-w-280 hidden'>
        <div class="space-y-4 xs:space-y-6 relative">
            <div class='flex items-center border border-white/50 rounded-2xl justify-around flex-col py-[8%] px-[12%] aspect-square bg-accent-foreground w-40 xs:w-50 lg:w-60'>
                <?php for ($i = 6; $i > 0; $i--) : ?>
                    <div cmp-iching-line="<?= $i ?>" class="flex overflow-hidden w-full text-background items-center justify-center">
                        <span class='h-1 w-full flex-1 bg-white'></span>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                    </div>
                <?php endfor; ?>
            </div>
            <p cmp-iching-num class="mb-2 text-white text-center text-3xl xs:text-4xl lg:text-5xl font-bold">27</p>
        </div>

        <p cmp-iching-interpretation
            class="text-pretty -mx-2 sm:mx-0">Эта гексаграмма символизирует сознательное уединение. Ваше нынешнее состояние подобно состоянию генерала, решающего, когда лучше всего начать наступление. Будьте внимательны, отбирайте себе в союзники людей с добрыми намерениями, и хотя удача в данный момент сопутствует вам, не забывайте о мерах предосторожности. Вы получите неожиданное известие, или вас посетит нежданный визитер. Настоящее время исполнено для вас романтики, что, впрочем, не помешало возникновению разлада с близким человеком. Все будущие дела планируйте тщательно и рассудительно.</p>

    </article>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden group-has-[[cmp-skeleton]]:hidden'
    ]) ?>

    <article
        cmp-visible-at-start
        cmp-visible-during
        class="md:rounded-2xl shadow-[10px_10px_20px_#00000040,0_1.5px_1px_#e1d4ff_inset] space-y-(--space-y) backdrop-blur-sm bg-linear-[180deg,#c8b5ff42,#ffffff30] -mx-7 p-(--space-y) sm:-mx-9 py-14.5 -mb-14.5 md:mb-0 md:mx-auto max-w-280">

        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => 'Бросить монеты',
            'attrs' => [
                'cmp-launch-game-btn' => true,
                'cmp-visible-at-start' => true,
                'cmp-visible-during' => true
            ],
            'class' => 'mx-auto'
        ]) ?>

        <ul class='space-y-6 md:space-y-8 mt-[calc(var(--space-y)*1.5)]'>
            <?php for ($i = 1; $i <= 3; $i++) : ?>
                <li class='flex items-center justify-between gap-6 xs:gap-10 md:gap-16 flex-wrap xs:flex-nowrap'>
                    <div cmp-iching-pattern="<?= $i ?>" class='p-4 w-full border border-white md:p-6 rounded-md flex masked items-center justify-center'>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                    </div>

                    <?= component('web/ui/flip-coin', [
                        'class' => 'size-20 md:size-30 flex-1 w-full -order-2 xs:order-0'
                    ]) ?>

                    <div cmp-iching-pattern="<?= $i + 3 ?>" class='p-4 w-full border border-white rounded-md md:p-6 masked flex items-center justify-center'>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                        <span class='h-1 w-full flex-1 bg-white'></span>
                    </div>
                </li>

            <?php endfor; ?>
        </ul>
    </article>
</div>
<template cmp-iching-scheme>
    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb|dk',
        'alt' => 'black-cat',
        'path'     => '/assets/images/pages/iching/scheme/iching-scheme',
        'prt_class' => 'w-full bg-contain!',
        'img_class' => 'size-full object-contain',
    ]) ?>
</template>

<template cmp-iching-preloader>
    <article
        cmp-skeleton
        class='flex flex-col items-center gap-4 md:flex-row md:items-start md:gap-[calc(var(--space-y)*1.5)] pb-(--space-y) lg:py-[calc(var(--space-y)/2)] mx-auto max-w-280'>
        <div class="space-y-4 xs:space-y-6 relative animate-pulse">
            <div class='flex items-center border border-white/50 rounded-2xl justify-around flex-col py-[8%] px-[12%] aspect-square bg-accent-foreground w-40 xs:w-50 lg:w-60'>
                <?php for ($i = 6; $i > 0; $i--) : ?>
                    <div class="flex overflow-hidden w-full text-background items-center justify-center">
                        <span class='h-1 w-full flex-1 bg-gray-300'></span>
                        <span class='h-1 w-full flex-1 bg-gray-300'></span>
                    </div>
                <?php endfor; ?>
            </div>
            <p class="mb-2 text-center text-3xl xs:text-4xl lg:text-5xl bg-gray-300 text-transparent w-fit mx-auto h-[1em] rounded-sm font-bold">27</p>
        </div>

        <p class="text-pretty -mx-2 space-y-[0.5em] sm:mx-0 w-full *:w-full *:bg-gray-300 *:animate-pulse *:block *:rounded-sm *:text-transparent">
            <span>a</span><span>a</span><span>a</span><span>a</span><span>a</span><span>a</span>
        </p>

    </article>
</template>
<?php $slot1 = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
