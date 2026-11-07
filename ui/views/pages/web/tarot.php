<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();
?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.карты_таро"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.карты_таро") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.пожалуй_нет_тех_кто_никогда_не_слышал_об_этих_древнейших_картах_знаменитые_карты_таро_это_дверей_к_внутренней_ясности_каждая_карта_дверь_в_сюжет_о_выборе_испытании_или_трансформации_случайный_выбор_карты_может_стать_ключом_к_неочевидному_ответу_который_уже_живет_внутри_вас") ?>
</p>
<?php $html = ob_get_clean();

$img_class = '2xl:max-w-[min(40%,30rem)]';
?>

<?php $image = '/assets/images/pages/tarot/hero-fg'; ?>

<?php $items = [
    [
        'id' => 1,
        'title' => $hive->get("web.карта_главное_сейчас"),
        'description' => $hive->get("web.одна_карта_один_фокус_она_подсказывает_на_что_стоит_обратить_внимание_сейчас"),
        'num' => 1
    ],
    [
        'id' => 2,
        'title' => $hive->get("web.карты_путь_ситуации"),
        'description' => $hive->get("web.три_карты_показывают_ситуацию_в_движении_откуда_она_берёт_начало_что_происходит_сейчас_и_куда_ведёт"),
        'num' => 3
    ],
    [
        'id' => 3,
        'title' => $hive->get("web.карт_глубокий_взгляд"),
        'description' => $hive->get("web.пять_карт_раскрывают_ситуацию_с_разных_сторон_что_происходит_внутри_и_вокруг_что_мешает_и_на_что_можно_опереться"),
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
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image', 'slot',  'img_class')); ?>
    <?= component('web/ui/set-num-items-btns', compact('items')); ?>
</section>


<?php ob_start(); ?>
<div>
    <div cmp-visible-at-start
        class='mx-auto max-w-xl'>

        <div cmp-card-meaning="1">
            <p><?= $hive->get("web.1_карта_главное_сейчас") ?></p>
            <p><?= $hive->get("web.одна_карта_один_фокус_она_подсказывает,_на_что_стоит_обратить_внимание_сейчас") ?></p>
        </div>

        <div cmp-card-meaning="3">
            <p><?= $hive->get("web.3_карты_путь_ситуации") ?></p>
            <ol class='list-decimal list-inside'>
                <li><?= $hive->get("web.истоки_что_привело_к_тому_что_происходит_сейчас") ?></li>
                <li><?= $hive->get("web.настоящий_момент_что_важно_здесь_и_сейчас") ?></li>
                <li><?= $hive->get("web.направление_куда_всё_движется_если_ничего_не_менять") ?></li>
            </ol>
            <p><?= $hive->get("web.описание_три_карты_показывают_ситуацию_в_движении_откуда_она_берёт_начало_что_происходит_сейчас_и_куда_ведёт") ?></p>
        </div>

        <div cmp-card-meaning="5">
            <p> <?= $hive->get("web.5_карт_глубокий_взгляд") ?></p>
            <ol>

                <ol class='list-decimal list-inside'>
                    <p><?= $hive->get("web.суть_о_чём_на_самом_деле_эта_ситуация") ?></p>
                    <p><?= $hive->get("web.внутри_твои_чувства_мысли_ожидания") ?></p>
                    <p><?= $hive->get("web.вокруг_обстоятельства_и_люди_которые_влияют") ?></p>
                    <p><?= $hive->get("web.препятствие_что_мешает_или_требует_внимания") ?></p>
                    <p><?= $hive->get("web.опора_что_поможет_пройти_этот_путь_спокойно_и_уверенно") ?></p>
                </ol>
                <p><?= $hive->get("web.описание_пять_карт_раскрывают_ситуацию_с_разных_сторон_что_происходит_внутри_и_вокруг_что_мешает_и_на_что_можно_опереться") ?></p>
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

    <?= component('web/layout/selected-items') ?>

    <?php slot('components/web/layout/card-deck', [
        'count' => count($cards),
        'gap' => 0.8,
        'attrs' => ['cmp-game' => GameType::TAROT->value]
    ]); ?>
    <?php foreach ($cards as $card) : ?>
        <?= component('web/ui/card', compact('card')) ?>
    <?php endforeach; ?>

    <?php end_slot(); ?>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.следующая_карта"),
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
        'class' => 'mx-auto -mt-2 lg:-mt-5 w-fit',
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
        class='text-balance mx-auto max-w-xl'><?= $hive->get("web.вы_сами_выбираете_карту_которая_откликается_сердцем_этот_способ_помогает_довериться_интуиции_и_увидеть_собственный_внутренний_ответ") ?>
    </p>

    <?= component('web/layout/selected-items') ?>

    <?php slot('components/web/layout/card-grid', [
        'attrs' => ['cmp-game' => GameType::TAROT->value]
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
        'class' => 'mx-auto -mt-2 lg:-mt-5 w-fit',
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
    'class' => 'hidden'
]); ?>

<?php end_slot(); ?>
