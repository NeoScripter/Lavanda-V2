<?php

use Enums\GameType;

extract(component_props(
    required: ['runes'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Спросить у рун',
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
        'title' => '1 руна',
        'description' => "Один символ. Одна подсказка. Для вопроса, который волнует тебя сегодня",
        'num' => 1
    ],
    [
        'id' => 2,
        'title' => '3 руны',
        'description' => "Три символа помогают увидеть ситуацию шире. Иногда сочетание рун имеет важное значение.",
        'num' => 3
    ],
    [
        'id' => 3,
        'title' => '5 рун',
        'description' => "Самый подробный расклад для тех, кто хочет разобраться в ситуации глубже.",
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
        'slot' => 'Получить ответ',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <?= component('web/layout/selected-items') ?>

    <?php slot('components/web/layout/planet-spinner', [
        'attrs' => ['cmp-game' => GameType::RUNES->value]
    ]); ?>
    <?php foreach ($runes as $rune) : ?>
        <?= component('web/ui/rune', compact('rune')) ?>
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
        Нажмите на руну, которая первой привлекла взгляд или куда потянулась рука
    </p>

    <?= component('web/layout/selected-items') ?>

    <ul cmp-game="<?= GameType::RUNES->value ?>">
        <?php foreach ($runes as $rune) : ?>
            <?= component('web/ui/flip-rune', [
                'rune' => $rune,
                'isPickable' => true,
            ]) ?>
        <?php endforeach; ?>

    </ul>

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
    // 'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
