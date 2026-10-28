<?php

use Enums\GameType;

$hive = \Base::instance();

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.метафорические_карты")
,
]); ?>

<?php ob_start(); ?>
 <?= $hive->get("web.метафорические_карты") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.не_все_вопросы_требуют_карт_или_символов_иногда_самый_короткий_путь_к_ответу_взять_лист_бумаги_посмотреть_на_ситуацию_с_другой_стороны_или_честно_ответить_самому_себе_на_несколько_вопросов_здесь_собраны_методики_которые_давно_используют_психологи_коучи_и_специалисты_по_принятию_решений_простые_понятные_и_удивительно_полезные") ?>
</p>
<?php $html = ob_get_clean(); ?>


<?php $image = '/assets/images/pages/metaphoric/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>
</section>


<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web.карта_открывается_сама_как_знак_который_приходит_вовремя_иногда_именно_случай_отражает_то_что_мы_уже_чувствуем_но_не_осознаём") ?>
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
        'attrs' => ['cmp-game' => GameType::METAPHORIC->value]
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

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
]); ?>

<?php end_slot(); ?>
