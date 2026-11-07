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
<?= $hive->get("web.спросить_у_рун") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.рунам_больше_полутора_тысяч_лет_когдато_их_вырезали_на_камне_оружии_и_украшениях_их_брали_с_собой_в_дорогу_и_обращались_к_ним_перед_важным_выбором_прошли_века_руны_остались_и_здесь_ты_поймешь_почему") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/runes/hero-fg'; ?>

<?php $items = [
    [
        'id' => 1,
        'title' => $hive->get("web.руна_руна_одина"),
        'description' => $hive->get("web.одна_руна_один_знак_то_что_важно_услышать_сегодня"),
        'num' => 1
    ],
    [
        'id' => 2,
        'title' => $hive->get("web.руны_нити_норн"),
        'description' => $hive->get("web.три_руны_три_нити_прошлое_которое_уже_сплетено_настоящее_которое_плетётся_сейчас_и_то_что_только_начинает_проявляться"),
        'num' => 3
    ],
    [
        'id' => 3,
        'title' => $hive->get("web.рун_древо"),
        'description' => "Пять рун раскрывают ситуацию как древо: из чего она растёт, к чему тянется, что её раскачивает и где источник сил.",
        'num' => 5
    ],
]; ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'accent',
    'slot' => $hive->get("web.следующий_раздел"),
    'href' => next_game_route(),
    'class' => 'w-fit',
]) ?>
<?php $slot = ob_get_clean(); ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
    <?= component('web/ui/set-num-items-btns', compact('items')); ?>
</section>

<?php ob_start(); ?>
<div>
    <div cmp-visible-at-start
        class='mx-auto max-w-xl'>

        <div cmp-rune-meaning="1">
            <p><?= $hive->get("web.1_руна_руна_одина") ?></p>
            <p><?= $hive->get("web.так_в_рунической_традиции_называют_вытягивание_одной_руны") ?></p>
            <p><?= $hive->get("web.описание_одна_руна_один_знак_то_что_важно_услышать_сегодня") ?></p>
        </div>

        <div cmp-rune-meaning="3">
            <p><?= $hive->get("web.3_руны_нити_норн") ?></p>
            <p><?= $hive->get("web.норны_в_скандинавских_мифах_три_хранительницы_которые_прядут_нити_судьбы_у_корней_мирового_древа") ?></p>
            <ol class='list-decimal list-inside'>
                <li><?= $hive->get("web.урд_то_что_уже_сплетено") ?></li>
                <li><?= $hive->get("web.верданди_то_что_происходит_сейчас") ?></li>
                <li><?= $hive->get("web.скульд_то_что_зреет_впереди") ?></li>
            </ol>
            <p><?= $hive->get("web.описание_три_руны_три_нити_прошлое_которое_уже_сплетено_настоящее_которое_плетётся_сейчас_и_то_что_только_начинает_проявляться") ?></p>

        </div>

        <div cmp-rune-meaning="5">
            <p><?= $hive->get("web.5_рун_древо") ?></p>
            <p><?= $hive->get("web.схема_по_образу_иггдрасиля_мирового_древа") ?></p>
            <ol class='list-decimal list-inside'>
                <li><?= $hive->get("web.ствол_суть_ситуации") ?></li>
                <li><?= $hive->get("web.корни_то_что_лежит_в_основе_и_идёт_из_глубины") ?></li>
                <li><?= $hive->get("web.крона_к_чему_ты_стремишься") ?></li>
                <li><?= $hive->get("web.ветер_что_мешает_или_испытывает_на_прочность") ?></li>
                <li><?= $hive->get("web.источник_откуда_брать_силу_и_опору") ?></li>
            </ol>
            <p><?= $hive->get("web.описание_пять_рун_раскрывают_ситуацию_как_древо_из_чего_она_растёт_к_чему_тянется_что_её_раскачивает_и_где_источник_сил") ?></p>
        </div>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ"),
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
        'slot' => $hive->get("web.следующая_руна"),
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-during' => true
        ],
        'class' => 'mx-auto'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'accent',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'mx-auto -mt-2 lg:-mt-5 mb-1 w-fit',
        'attrs' => [
            'cmp-visible-at-end' => true,
            'cmp-visible-at-start' => true
        ],
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web.нажмите_на_руну_которая_первой_привлекла_взгляд_или_куда_потянулась_рука") ?>
    </p>

    <?= component('web/layout/selected-items', [
        'class' => '[&>li]:aspect-square bg-linear-(--bg-linear-pale) shadow-accent rounded-2xl p-5 backdrop-blur-sm'
    ]) ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.перемешать"),
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
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>
    <?= component('web/ui/button', [
        'variant' => 'accent',
        'slot' => $hive->get("web.следующий_раздел"),
        'href' => next_game_route(),
        'class' => 'mx-auto -mt-2 lg:-mt-5 mb-1 w-fit',
        'attrs' => [
            'cmp-visible-at-end' => true,
            'cmp-visible-at-start' => true
        ],
    ]) ?>

    <?= component('web/ui/arrow-hint') ?>
</div>
<?php $slot2 = ob_get_clean(); ?>

<?php $labels = [
    $hive->get("web.выбор_лаванды"),
    $hive->get("web.выбор_гостя")
]; ?>

<?= component('web/layout/game-stage', [
    'labels' => $labels,
    'slots' => [$slot1, $slot2],
    'class' => 'runes hidden'
]); ?>

<?php end_slot(); ?>
