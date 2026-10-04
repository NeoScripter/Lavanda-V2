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
<p>Проверим, умеет ли Лаванда удивлять?</p>
<p>Выберите карту и посмотрите, какое послание ждёт именно вас. Это займёт меньше минуты, однако часто одна случайная встреча с образом оказывается удивительно своевременной.</p>
<p>Этот раздел доступен всем и всегда, с него удобно начать знакомство с Lavanda Kim и нашей авторской колодой.</p>
<p>Никаких сложных раскладов. Просто одна карта. Один символ. И, возможно, одна важная мысль.</p>
<p>Ну что, попробуем?</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => 'Перейти к игре',
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/bonus/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>


<?php ob_start(); ?>
<div class='items-center space-y-8 lg:space-y-12'>
    <p class='text-balance mx-auto max-w-xl'>Карта открывается сама — как знак, который приходит вовремя. Иногда именно случай отражает то, что мы уже чувствуем, но не осознаём.</p>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
        'attrs' => ['cmp-launch-game-btn' => true],
        'class' => 'mx-auto'
    ]) ?>

    <?php slot('components/web/layout/card-deck', [
        'count' => count($cards),
        'gap' => 0.8,
        'attrs' => ['cmp-game' => GameType::BONUS->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/card', compact('card')) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>
Hello world 2
<?php $slot2 = ob_get_clean(); ?>

<?php $labels = ['Выбор лаванды', 'Выбор гостя']; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot1, $slot2],
    // 'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
