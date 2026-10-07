<?php

use Enums\GameType;

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Игры разума',
]); ?>

<?php ob_start(); ?>
Игры разума
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Этот простой, но невероятно действенный полезный инструмент в виде колоды МАК я получила от <a href="https://mak.arcanes.ru/" target="_blank"> Ирины Федоровой.</a> Ирина - психолог-консультант, парапсихолог, автор колод метафорических ассоциативных карт, член Профессиональной Гильдии психологов, действительный член Профессиональной психотерапевтической лиги.</p>
<p>С разрешения автора эти карты используются и у нас. Колода может быть использована для поиска подсказки или совета на все случаи жизни. Ее можно купить в печатном виде и носить с собой, она специально сделана не тяжелой. На нашем сайте представлена цифровая колода.</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => 'Перейти к игре',
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/mind-games/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>

<section class='[&:has(+_[cmp-game-stage].hidden)]:hidden'>
    <h2>Описание и правила работы с МАК «Игры Разума»</h2>
    <p class='text-center text-balance max-w-200 mx-auto'>
        Колода содержит черно-белые карты с различными фразами и советами на все случаи жизни. Вы можете <strong>выбрать среди них «вашу» фразу под текущий запрос, которую сразу же «поймает» взгляд.</strong> Можно искать «знаки свыше» повсюду, читать уличные вывески, названия кафе или принты на футболках встреченных вами людей, «зацепить взглядом» острую фразу газетного или журнального заголовка через плечо другого пассажира в автобусе или метро, услышать случайную реплику прохожего и трактовать ее в созвучном собственному состоянию ключе, а также многие другие «знаки», способные зачастую отвечать порой на самые животрепещущие вопросы. <strong>А можно взять эту колоду МАК, в которой собрана мудрость из самых разных источников, которую можно запомнить, перечитать и осмыслить еще разок при необходимости, она всегда в ближайшей зоне доступа и готова помочь советом.</strong>
    </p>
</section>

<?php ob_start(); ?>
<div>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        Самая первая фраза, которая буквально «бросится вам в глаза» – это и будет совет. Опишите (желательно проговорить вслух или записать), что вы увидели и почувствовали о своем запросе. Сделайте выводы.
    </p>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Получить ответ',
        'attrs' => [
            'cmp-launch-game-btn' => true,
            'cmp-visible-at-start' => true
        ],
        'class' => 'mx-auto'
    ]) ?>

    <?= component('web/layout/selected-items', ['class' => '[&>li]:max-w-120']) ?>

    <?php slot('components/web/layout/card-deck', [
        'count' => count($cards),
        'gap' => 0.8,
        'attrs' => ['cmp-game' => GameType::MIND_GAMES->value]
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
    'class' => 'hidden',
]); ?>

<?php end_slot(); ?>
