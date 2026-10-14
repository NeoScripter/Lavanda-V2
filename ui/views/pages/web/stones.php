<?php

use Enums\GameType;

extract(component_props(
    required: ['stones'],
    optional: [],
    props: get_defined_vars(),
));

$winner_id = $stones[array_rand($stones)]['id']; ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Магические камни',
]); ?>

<?php ob_start(); ?>
70 камней в одном мешочке
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><strong>Какой сегодня окажется рядом?</strong></p>
<p class='mb-0'>Перед Вами 70 камней. Один из них окажется рядом именно сейчас. У каждого минерала — свой характер, своя история и свой способ быть опорой.</p>  
<p>Выберите камень и узнайте, с чем он может сопровождать Вас.</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => 'Перейти к игре',
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/stones/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image', 'slot')); ?>
</section>

<section class='[&:has(+_[cmp-game-stage].hidden)]:hidden'>
    <p class='text-center text-balance max-w-200 mx-auto'>
        Каждое значение — это подсказка, предостережение или напутствие на ближайшее будущее. Узнайте, что вам шепчет камень — возможно, ответ уже лежит на ладони.
    </p>
</section>


<?php ob_start(); ?>
<div>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <?= component('web/layout/selected-items') ?>

    <article cmp-game="<?= GameType::STONE->value ?>"
        data-winner-id="<?= $winner_id ?>">
    </article>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class='relative'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'z-20 left-1/2 top-1/2 -translate-1/2 absolute!'
    ]) ?>

    <ul class="grid grid-rows-3 grid-cols-3 h-200 place-content-center place-items-center md:h-auto md:aspect-square max-w-160 mx-auto"
        cmp-stone-grid
        cmp-rune-grid
        data-winner-id="<?= $winner_id ?>"
        cmp-game="<?= GameType::STONE->value ?>">
        <?php foreach ($stones as $idx => $stone) : ?>
            <?= component('web/ui/stone', [
                'stone' => $stone,
                'idx' => $idx,
                'class' => 'w-20 md:w-22 lg:w-25',
            ]) ?>
        <?php endforeach; ?>
    </ul>

    <div cmp-visible-during 
        cmp-visible-at-end
        class='absolute starting:opacity-0 transition-opacity inset-0 z-20 left-1/2 top-1/2 -translate-1/2 aspect-square w-3/2 xs:w-full md:w-2/3 lg:w-1/2'>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => 'cloth',
            'path'     => '/assets/images/pages/stones/cloth',
            'prt_class' => 'w-full bg-contain!',
            'img_class' => 'size-full object-contain',
        ]) ?>
        <div class='absolute left-1/2 top-0 -translate-x-1/2 backdrop-blur-sm border border-white rounded-lg p-4 w-[min(100vw,25rem)] md:left-0 md:translate-x-0'>
            <span class='absolute left-0 top-0 hidden sm:block -translate-1/2 size-7 backdrop-blur-sm *:size-full rounded-full text-white'>
                <?= svg('info-circle') ?>
            </span>
            Нажмите в любую область платка, чтобы вытянуть камень
        </div>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать снова',
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot2 = ob_get_clean(); ?>

<?php $labels = ['Выбор лаванды', 'Выбор гостя']; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot2, $slot1],
    'class' => 'stones'
]); ?>

<?php end_slot(); ?>
