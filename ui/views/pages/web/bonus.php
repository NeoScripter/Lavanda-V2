<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Бонусная игра',
]); ?>

<?php ob_start(); ?>
Экспресс-карта от Lavanda<sup>Kim</sup>
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Почему ты здесь именно сегодня?</p>
<p>Давай начнем знакомство.</p>

<p>Открой одну карту авторского оракула TheCat и посмотри, что она расскажет о том, что привело тебя сюда. Знаешь, порой одна случайная встреча с образом оказывается удивительно своевременной.</p>
<p>Никаких сложных раскладов. Одна карта. Один символ.</p>
<p>И, возможно, ответ, который нам сейчас нужен.</p>
<p>А дальше Lavanda подскажет, какой инструмент поможет разобраться глубже.</p>
<p>Ну что, попробуем?</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class='flex flex-wrap gap-y-4 gap-x-6 lg:gap-x-8'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Попробовать',
        'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'muted',
        'slot' => 'Идем дальше',
    ]) ?>
</div>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/bonus/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
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
        'attrs' => ['cmp-game' => GameType::BONUS->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/card', compact('card')) ?>
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
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        Вы сами выбираете карту, которая откликается сердцем. Этот способ помогает довериться интуиции и увидеть собственный внутренний ответ.
    </p>

    <?= component('web/layout/selected-items') ?>

    <?php slot('components/web/layout/card-grid', [
        'attrs' => ['cmp-game' => GameType::BONUS->value]
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
