<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Карты Таро',
]); ?>

<?php ob_start(); ?>
Карты Таро
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Пожалуй, нет тех, кто никогда не слышал об этих древнейших картах. Знаменитые карты Таро - это 78 дверей к внутренней ясности. Каждая карта — дверь в сюжет о выборе, испытании или трансформации. Случайный выбор карты может стать ключом к неочевидному ответу, который уже живет внутри вас.</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/tarot/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>
    <?= component('web/ui/set-num-items-btns'); ?>
</section>


<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>Карта открывается сама — как знак, который приходит вовремя. Иногда именно случай отражает то, что мы уже чувствуем, но не осознаём.</p>

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

    <?php slot('components/web/layout/card-deck', [
        'count' => count($cards),
        'gap' => 0.8,
        'attrs' => ['cmp-game' => GameType::TAROT->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/card', compact('card')) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Следующая карта',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-during' => true
        ],
        'class' => 'mx-auto'
    ]) ?>
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
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        Вы сами выбираете карту, которая откликается сердцем. Этот способ помогает довериться интуиции и увидеть собственный внутренний ответ.
    </p>

    <?= component('web/layout/selected-items') ?>

    <?php slot('components/web/layout/card-grid', [
        'attrs' => ['cmp-game' => GameType::TAROT->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/flip-card', [
            'card' => $card,
            'isPickable' => true,
            'class' => 'grid-row-2/3'
        ]) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

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
    'slots' => [$slot1, $slot2],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
