<?php

use Enums\GameType;

extract(component_props(
    required: ['runes'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php $hive = \Base::instance(); ?>
<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.спросить_у_рун"),
]); ?>

<?php ob_start(); ?>
Спросить у рун
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Рунам больше полутора тысяч лет. Когда-то их вырезали на камне, оружии и украшениях, их брали с собой в дорогу и обращались к ним перед важным выбором. Прошли века. Руны остались. И здесь ты поймешь, почему</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/runes/hero-fg'; ?>

<?php $items = [
    [
        'id' => 1,
        'title' => $hive->get("web._руна_руна_одина"),
        'description' => $hive->get("web.одна_руна_один_знак_то_что_важно_услышать_сегодня"),
        'num' => 1
    ],
    [
        'id' => 2,
        'title' => $hive->get("web._руны_нити_норн"),
        'description' => $hive->get("web.три_руны_три_нити_прошлое_которое_уже_сплетено_настоящее_которое_плетётся_сейчас_и_то_что_только_начинает_проявляться_"),
        'num' => 3
    ],
    [
        'id' => 3,
        'title' => $hive->get("web._рун_древо"),
        'description' => "Пять рун раскрывают ситуацию как древо: из чего она растёт, к чему тянется, что её раскачивает и где источник сил.",
        'num' => 5
    ],
]; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>
    <?= component('web/ui/set-num-items-btns', compact('items')); ?>
</section>

<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        Руна открывается сама — как знак, который приходит извне. Это словно довериться потоку и принять то, что должно проявиться именно сейчас.</p>

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

    <?= component('web/layout/selected-items', [
        'class' => '[&>li]:aspect-square bg-linear-(--bg-linear-pale) shadow-accent rounded-2xl p-5 backdrop-blur-sm'
    ]) ?>

    <?php slot('components/web/layout/planet-spinner', [
        'count' => count($runes),
        'attrs' => ['cmp-game' => GameType::RUNE->value]
    ]); ?>
    <?php foreach ($runes as $idx => $rune) : ?>
        <?= component('web/ui/rune', [
            'rune' => $rune,
            'idx' => $idx,
            'side' => 'front',
            'class' => $idx === 0 ? 'current' : ''
        ]) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => qquila1Следующая рунаqquila2
,
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-during' => true
        ],
        'class' => 'mx-auto'
    ]) ?>
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
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        Нажмите на руну, которая первой привлекла взгляд или куда потянулась рука
    </p>

    <?= component('web/layout/selected-items', [
        'class' => '[&>li]:aspect-square bg-linear-(--bg-linear-pale) shadow-accent rounded-2xl p-5 backdrop-blur-sm'
    ]) ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => qquila1Перемешатьqquila2
,
        'attrs' => [
            'cmp-shuffle-runes-btn' => true,
            'cmp-visible-during' => true,
            'cmp-visible-at-start' => true,
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <ul class="grid grid-rows-3 grid-cols-3 h-200 place-content-center place-items-center md:h-auto md:aspect-square max-w-160 mx-auto"
        cmp-rune-grid
        cmp-game="<?= GameType::RUNE->value ?>">
        <?php foreach ($runes as $idx => $rune) : ?>
            <?= component('web/ui/flip-rune', [
                'rune' => $rune,
                'isPickable' => true,
                'idx' => $idx,
                'class' => 'w-20 md:w-22 lg:w-25',
            ]) ?>
        <?php endforeach; ?>
    </ul>

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
    'class' => 'runes hidden'
]); ?>

<?php end_slot(); ?>
