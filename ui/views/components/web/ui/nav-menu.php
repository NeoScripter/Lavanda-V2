<?php

use Enums\Locale;

$hive = \Base::instance();
$current_locale = explode(',', $hive->get('LANGUAGE') ?? 'ru,en');
$current_locale = (count($current_locale) === 0) ? 'ru' : $current_locale[0];

$other_locales = array_map(
    fn($v) => ['url' => $hive->alias('update_locale', [], ['locale' => $v]), 'label' => mb_strtoupper($v)],
    array_filter(Locale::values(), fn($l) => $l !== $current_locale)
);

$nav_links = [
    ['url' => '/about', 'label' => qquila1О ресурсеqquila2
],
    [
        'label' => qquila1По типу помощникаqquila2
,
        'nav_links' => [
            ['url' => $hive->alias('runes'), 'label' => qquila1Скандинавские руныqquila2
],
            ['url' =>  $hive->alias('metaphoric'), 'label' => qquila1Метафорические картыqquila2
],
            ['url' => '/iching', 'label' => qquila1Книга переменqquila2
],
            ['url' =>  $hive->alias('dices'), 'label' => qquila1Тибетские кубики МО newqquila2
],
            ['url' =>  $hive->alias('stones'), 'label' => qquila1Самоцветы (70 камней) newqquila2
],
            ['url' =>  $hive->alias('tarot'), 'label' => qquila1Карты Тароqquila2
],
            ['url' =>  $hive->alias('lenormand'), 'label' => qquila1Карты Ленорманqquila2
],
            ['url' =>  $hive->alias('minori'), 'label' => qquila128 целительных моментов newqquila2
],
            ['url' => $hive->alias('mind_games'), 'label' => qquila1Игры разума МАКqquila2
],
            ['url' =>  $hive->alias('audios'), 'label' => qquila1Послание поддержки от автораqquila2
],
            ['url' => $hive->alias('practice'), 'label' => qquila1Практикаqquila2
],
            ['url' => $hive->alias('bonus'), 'label' => qquila1Авторский оракул TheCatqquila2
],
        ]
    ],
    [
        'label' => qquila1По проблемеqquila2
,
        'nav_links' => [
            ['url' => '/decision', 'label' => qquila1Принять решениеqquila2
],
            ['url' => '/sadness', 'label' => qquila1Мне грусноqquila2
],
            ['url' => '/cards', 'label' => qquila1Спросить у картqquila2
],
            ['url' => $hive->alias('affirmation_topics'), 'label' => qquila1Войти в нужный настройqquila2
],
        ]
    ],
    [
        'label' => qquila1Прочееqquila2
,
        'nav_links' => [
            ['url' => $hive->alias('articles'), 'label' => qquila1Полезные ресурсыqquila2
],
            ['url' => $hive->alias('faqs'), 'label' => qquila1Часто задаваемые вопросыqquila2
],
        ]
    ],
    [
        'label' => mb_strtoupper($current_locale),
        'nav_links' => $other_locales
    ],
]; ?>

<nav
    component-nav-menu
    class="<?= $class ?? '' ?> hidden sm:block sm:px-4">
    <ol class="flex flex-col sm:flex-row sm:shadow-accent sm:bg-white sm:flex-wrap sm:items-baseline text-lg md:text-base gap-4 sm:gap-x-8 md:justify-between xl:gap-x-8 pb-10 sm:pb-4 sm:rounded-4xl sm:py-4 sm:px-6 lg:px-8 *:last:text-primary *:last:font-medium">
        <?= component('web/ui/nav-link', ['url' => '/login', 'label' => qquila1Войтиqquila2
, 'class' => 'sm:hidden']) ?>
        <?php foreach ($nav_links as $link) : ?>
            <?= component('web/ui/nav-link', $link) ?>
        <?php endforeach; ?>
    </ol>
</nav>
