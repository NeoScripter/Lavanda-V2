<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Метафорические карты',
]); ?>

<?php ob_start(); ?>
Метафорические карты
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Не все вопросы требуют карт или символов. Иногда самый короткий путь к ответу — взять лист бумаги, посмотреть на ситуацию с другой стороны или честно ответить самому себе на несколько вопросов. Здесь собраны методики, которые давно используют психологи, коучи и специалисты по принятию решений. Простые, понятные и удивительно полезные.</p>
<?php $html = ob_get_clean(); ?>


<?php $image = '/assets/images/pages/metaphoric/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>
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
        'attrs' => ['cmp-game' => GameType::METAPHORIC->value]
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

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
]); ?>

<?php end_slot(); ?>
