<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => qquila1Карты Минориqquila2
,
]); ?>

<?php ob_start(); ?>
Тихие моменты покоя
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Чашка чая или ароматный кофе. Любимая книга. Лучики солнца из окна. Цветок в комнате. Мысль, которая пришла внезапно и согрела. Иногда именно из таких мелочей и складывается тёплый день.</p>
<p>28 карточек - 28 маленьких поводов остановиться, посмотреть вокруг и насладиться этим моментом.</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => qquila1Открыть моментqquila2
,
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/minori/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>


<?php ob_start(); ?>
<div>


    <?php if (! empty($cards)) : ?>
        <p cmp-visible-at-start class='text-balance mx-auto max-w-xl'>Карта открывается сама — как знак, который приходит вовремя. Иногда именно случай отражает то, что мы уже чувствуем, но не осознаём.</p>

        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => qquila1Получить ответqquila2
,
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
            'attrs' => ['cmp-game' => GameType::MINORI->value]
        ]); ?>
        <?php foreach ($cards as $card) : ?>
            <?= component('web/ui/card', compact('card')) ?>
        <?php endforeach; ?>

        <?php end_slot(); ?>
    <?php else : ?>
        <p class='mx-auto max-w-xl'>Пока не добавлено ни одной карты</p>
    <?php endif; ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => qquila1Попробовать сноваqquila2
,
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
    <?php if (! empty($cards)) : ?>
        <p cmp-visible-at-start class='text-balance mx-auto max-w-xl'> Вы сами выбираете карту, которая откликается сердцем. Этот способ помогает довериться интуиции и увидеть собственный внутренний ответ. </p>

        <?= component('web/layout/selected-items') ?>

        <?php slot('components/web/layout/card-grid', [
            'attrs' => ['cmp-game' => GameType::MINORI->value]
        ]); ?>
        <?php foreach ($cards as $card) : ?>
            <?= component('web/ui/flip-card', [
                'card' => $card,
                'isPickable' => true,
                'class' => 'grid-row-2/3'
            ]) ?>
        <?php endforeach; ?>

        <?php end_slot(); ?>
    <?php else : ?>
        <p class='mx-auto max-w-xl'>Пока не добавлено ни одной карты</p>
    <?php endif; ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => qquila1Попробовать сноваqquila2
,
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot2 = ob_get_clean(); ?>

<?php $labels = [qquila1Выбор лавандыqquila2
, qquila1Выбор гостяqquila2
]; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot1, $slot2],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
