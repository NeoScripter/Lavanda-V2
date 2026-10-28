<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.бонусная_игра")
,
]); ?>

<?php ob_start(); ?>
 <?= $hive->get("web.экспресскарта_от_") ?>
<sup>Kim</sup>
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>qquila1Почему ты здесь именно сегодня? qquila2
</p>
<p><?= $hive->get("web.давай_начнем_знакомство_") ?>
</p>

<p><?= $hive->get("web.открой_одну_карту_авторского_оракула_и_посмотри_что_она_расскажет_о_том_что_привело_тебя_сюда_знаешь_порой_одна_случайная_встреча_с_образом_оказывается_удивительно_своевременной_") ?>
</p>
<p><?= $hive->get("web.никаких_сложных_раскладов_одна_карта_один_символ_") ?>
</p>
<p><?= $hive->get("web.и_возможно_ответ_который_нам_сейчас_нужен_") ?>
</p>
<p><?= $hive->get("web.а_дальше_подскажет_какой_инструмент_поможет_разобраться_глубже_") ?>
</p>
<p>qquila1Ну что, попробуем? qquila2
</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class='flex flex-wrap gap-y-4 gap-x-6 lg:gap-x-8'>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать")
,
        'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'muted',
        'slot' => $hive->get("web.идем_дальше")
,
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
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web.карта_открывается_сама_как_знак_который_приходит_вовремя_иногда_именно_случай_отражает_то_что_мы_уже_чувствуем_но_не_осознаём_") ?>
</p>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ")
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
        'attrs' => ['cmp-game' => GameType::BONUS->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/card', compact('card')) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова")
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
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web._вы_сами_выбираете_карту_которая_откликается_сердцем_этот_способ_помогает_довериться_интуиции_и_увидеть_собственный_внутренний_ответ_") ?>
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
        'slot' => $hive->get("web.попробовать_снова")
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

<?php $labels = [$hive->get("web.выбор_лаванды")
, $hive->get("web.выбор_гостя")
]; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot1, $slot2],
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
