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

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>
    <?= component('web/ui/set-num-items-btns', compact('items')); ?>
</section>

<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web.руна_открывается_сама_как_знак_который_приходит_извне_это_словно_довериться_потоку_и_принять_то_что_должно_проявиться_именно_сейчас") ?>
    </p>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.получить_ответ"),
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <div cmp-visible-at-end class='max-w-150 mx-auto hidden'>
        <div cmp-rune-meaning="1">
            <p>1 руна — «Руна Одина»</p>
            <p>Так в рунической традиции называют вытягивание одной руны.</p>
            <p>Описание: Одна руна — один знак. То, что важно услышать сегодня.</p>
        </div>

        <div cmp-rune-meaning="3">
            <p>3 руны — «Нити Норн»</p>
            <p>Норны в скандинавских мифах — три хранительницы, которые прядут нити судьбы у корней мирового древа.</p>
            <ol class='list-decimal list-inside'>
                <li>Урд · то, что уже сплетено</li>
                <li>Верданди · то, что происходит сейчас</li>
                <li>Скульд · то, что зреет впереди</li>
            </ol>
            <p>Описание: Три руны — три нити: прошлое, которое уже сплетено, настоящее, которое плетётся сейчас, и то, что только начинает проявляться.</p>
        </div>

        <div cmp-rune-meaning="5">
            <p>5 рун — «Древо»</p>
            <p>Схема по образу Иггдрасиля, мирового древа:</p>
            <ol class='list-decimal list-inside'>
                <li>Ствол · суть ситуации</li>
                <li>Корни · то, что лежит в основе и идёт из глубины</li>
                <li>Крона · к чему ты стремишься</li>
                <li>Ветер · что мешает или испытывает на прочность</li>
                <li>Источник · откуда брать силу и опору</li>
            </ol>
            <p>Описание: Пять рун раскрывают ситуацию как древо: из чего она растёт, к чему тянется, что её раскачивает и где источник сил.</p>
        </div>
    </div>

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
