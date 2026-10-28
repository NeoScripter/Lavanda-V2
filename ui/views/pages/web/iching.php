<?php

$hive = \Base::instance();

slot('layouts/web/app-layout', [
    'title' => $hive->get("web.таблица_гексаграмм"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.таблица_гексаграмм_") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.книга_перемен_сопровождает_китайскую_философию_почти_три_тысячи_лет_её_не_читают_как_обычную_книгу_с_ней_советуются_каждая_гексаграмма_предлагает_не_готовый_ответ_а_другой_взгляд_на_происходящее_позволяя_увидеть_ситуацию_шире_") ?> </p>
<p><?= $hive->get("web.бросай_три_древние_монеты_и_расшифруй_свою_гексаграмму_") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.перейти_к_игре"),
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/iching/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>


<?php ob_start(); ?>
<div cmp-iching-game class="group isolate relative">
    <div cmp-visible-at-start
        class='mx-auto max-w-200 *:py-[0.5em]'>
        <h2 class="text-white text-2xl md:text-3xl lg:text-4xl"><?= $hive->get("web.правила_") ?>
        </h2>
        <p>

            qquila1Суть метода работы с “Книгой Перемен” получить гексаграмму (набор из 6 линий) и изучить ее интерпретацию, которая часто даже очень точна по срокам. qquila2

        </p>
        <p><?= $hive->get("web.на_данный_момент_самый_распространенный_вид_получения_гексаграммы_с_монетами_три_монеты_подбрасываются_раз_формируя_гексаграмму_") ?> </p>
        <p><?= $hive->get("web.в_нашем_случае_специальные_алгоритмы_воспроизводят_работу_с_монетами_формируя_последовательно_гексаграмму_затем_вы_получаете_трактование_сформированной_гексаграммы_") ?> </p>
        <p>

            qquila1Вы также можете самостоятельно оффлайн сформировать гексаграмму с помощью трех монет (можно древних или иногда советуют брать серебряные). А затем, по полученной гексаграмме, найти трактование на нашем уютном Лавандовом Пространстве. qquila2

        </p>
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
            class="text-pretty -mx-2 sm:mx-0"><?= $hive->get("web.эта_гексаграмма_символизирует_сознательное_уединение_ваше_нынешнее_состояние_подобно_состоянию_генерала_решающего_когда_лучше_всего_начать_наступление_будьте_внимательны_отбирайте_себе_в_союзники_людей_с_добрыми_намерениями_и_хотя_удача_в_данный_момент_сопутствует_вам_не_забывайте_о_мерах_предосторожности_вы_получите_неожиданное_известие_или_вас_посетит_нежданный_визитер_настоящее_время_исполнено_для_вас_романтики_что_впрочем_не_помешало_возникновению_разлада_с_близким_человеком_все_будущие_дела_планируйте_тщательно_и_рассудительно_") ?>
        </p>

    </article>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова"),
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
            'slot' => $hive->get("web.бросить_монеты"),
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
