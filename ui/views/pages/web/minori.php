<?php

use Enums\GameType;

$hive = \Base::instance();

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.карты_минори")
,
]); ?>

<?php ob_start(); ?>
 <?= $hive->get("web.тихие_моменты_покоя") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.чашка_чая_или_ароматный_кофе_любимая_книга_лучики_солнца_из_окна_цветок_в_комнате_мысль_которая_пришла_внезапно_и_согрела_иногда_именно_из_таких_мелочей_и_складывается_тёплый_день") ?>
</p>
<p><?= $hive->get("web.карточек_маленьких_поводов_остановиться_посмотреть_вокруг_и_насладиться_этим_моментом") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.открыть_момент")
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
        <p cmp-visible-at-start class='text-balance mx-auto max-w-xl'><?= $hive->get("web.карта_открывается_сама_как_знак_который_приходит_вовремя_иногда_именно_случай_отражает_то_что_мы_уже_чувствуем_но_не_осознаём") ?>
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
            'attrs' => ['cmp-game' => GameType::MINORI->value]
        ]); ?>
        <?php foreach ($cards as $card) : ?>
            <?= component('web/ui/card', compact('card')) ?>
        <?php endforeach; ?>

        <?php end_slot(); ?>
    <?php else : ?>
        <p class='mx-auto max-w-xl'><?= $hive->get("web.пока_не_добавлено_ни_одной_карты") ?>
</p>
    <?php endif; ?>

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
    <?php if (! empty($cards)) : ?>
        <p cmp-visible-at-start class='text-balance mx-auto max-w-xl'><?= $hive->get("web.вы_сами_выбираете_карту_которая_откликается_сердцем_этот_способ_помогает_довериться_интуиции_и_увидеть_собственный_внутренний_ответ") ?>
</p>

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
        <p class='mx-auto max-w-xl'><?= $hive->get("web.пока_не_добавлено_ни_одной_карты") ?>
</p>
    <?php endif; ?>

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
