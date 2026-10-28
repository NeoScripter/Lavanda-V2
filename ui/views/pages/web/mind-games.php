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
    'title' => $hive->get("web.игры_разума"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.игры_разума") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p><?= $hive->get("web.этот_простой_но_невероятно_действенный_полезный_инструмент_в_виде_колоды_мак_я_получила_от") ?>
    <a href="https://mak.arcanes.ru/" target="_blank"><?= $hive->get("web.ирины_федоровой") ?>
    </a><?= $hive->get("web.ирина_психологконсультант_парапсихолог_автор_колод_метафорических_ассоциативных_карт_член_профессиональной_гильдии_психологов_действительный_член_профессиональной_психотерапевтической_лиги") ?>
</p>
<p><?= $hive->get("web.с_разрешения_автора_эти_карты_используются_и_у_нас_колода_может_быть_использована_для_поиска_подсказки_или_совета_на_все_случаи_жизни_ее_можно_купить_в_печатном_виде_и_носить_с_собой_она_специально_сделана_не_тяжелой_на_нашем_сайте_представлена_цифровая_колода") ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php ob_start(); ?>
<?= component('web/ui/button', [
    'variant' => 'primary',
    'slot' => $hive->get("web.перейти_к_игре"),
    'attrs' => ['cmp-hide-on-click' => true, 'cmp-reveal-game-btn' => true],
]) ?>
<?php $slot = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/mind-games/hero-fg'; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'slot', 'image')); ?>
</section>

<section class='[&:has(+_[cmp-game-stage].hidden)]:hidden'>
    <h2><?= $hive->get("web.описание_и_правила_работы_с_мак_игры_разума") ?>
    </h2>
    <p class='text-center text-balance max-w-200 mx-auto'><?= $hive->get("web.колода_содержит_чернобелые_карты_с_различными_фразами_и_советами_на_все_случаи_жизни_вы_можете") ?>
        <strong><?= $hive->get("web.выбрать_среди_них_вашу_фразу_под_текущий_запрос_которую_сразу_же_поймает_взгляд") ?>
        </strong><?= $hive->get("web.можно_искать_знаки_свыше_повсюду_читать_уличные_вывески_названия_кафе_или_принты_на_футболках_встреченных_вами_людей_зацепить_взглядом_острую_фразу_газетного_или_журнального_заголовка_через_плечо_другого_пассажира_в_автобусе_или_метро_услышать_случайную_реплику_прохожего_и_трактовать_ее_в_созвучном_собственному_состоянию_ключе_а_также_многие_другие_знаки_способные_зачастую_отвечать_порой_на_самые_животрепещущие_вопросы") ?>
        <strong><?= $hive->get("web.а_можно_взять_эту_колоду_мак_в_которой_собрана_мудрость_из_самых_разных_источников_которую_можно_запомнить_перечитать_и_осмыслить_еще_разок_при_необходимости_она_всегда_в_ближайшей_зоне_доступа_и_готова_помочь_советом") ?>
        </strong>
    </p>
</section>

<?php ob_start(); ?>
<div class='relative isolate'>
    <p cmp-visible-at-start
        class='text-balance mx-auto max-w-xl'>
        <?= $hive->get('web.самая_первая_фраза_которая_буквально_бросится_вам_в_глаза_это_и_будет_совет_опишите_желательно_проговорить_вслух_или_записать_что_вы_увидели_и_почувствовали_о_своем_запросе_сделайте_выводы') ?>
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
        'slot' => $hive->get("web.попробовать_снова"),
        'attrs' => [
            'cmp-reset-game-btn' => true,
            'cmp-visible-at-end' => true
        ],
        'class' => 'mx-auto hidden'
    ]) ?>

    <div cmp-interpretation class='absolute inset-0 hidden z-10'></div>
</div>
<?php $slot1 = ob_get_clean(); ?>

<?= component('web/layout/game-stage', [
    'slots' => [$slot1],
    'class' => 'hidden',
]); ?>

<?php end_slot(); ?>
