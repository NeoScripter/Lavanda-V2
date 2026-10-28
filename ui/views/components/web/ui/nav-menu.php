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
    ['url' => '/about', 'label' => $hive->get("web.о_ресурсе")
],
    [
        'label' => $hive->get("web.по_типу_помощника")
,
        'nav_links' => [
            ['url' => $hive->alias('runes'), 'label' => $hive->get("web.скандинавские_руны")
],
            ['url' =>  $hive->alias('metaphoric'), 'label' => $hive->get("web.метафорические_карты")
],
            ['url' => '/iching', 'label' => $hive->get("web.книга_перемен")
],
            ['url' =>  $hive->alias('dices'), 'label' => $hive->get("web.тибетские_кубики_мо_")
],
            ['url' =>  $hive->alias('stones'), 'label' => qquila1Самоцветы (70 камней) newqquila2
],
            ['url' =>  $hive->alias('tarot'), 'label' => $hive->get("web.карты_таро")
],
            ['url' =>  $hive->alias('lenormand'), 'label' => $hive->get("web.карты_ленорман")
],
            ['url' =>  $hive->alias('minori'), 'label' => $hive->get("web._целительных_моментов_")
],
            ['url' => $hive->alias('mind_games'), 'label' => $hive->get("web.игры_разума_мак")
],
            ['url' =>  $hive->alias('audios'), 'label' => $hive->get("web.послание_поддержки_от_автора")
],
            ['url' => $hive->alias('practice'), 'label' => $hive->get("web.практика")
],
            ['url' => $hive->alias('bonus'), 'label' => $hive->get("web.авторский_оракул_")
],
        ]
    ],
    [
        'label' => $hive->get("web.по_проблеме")
,
        'nav_links' => [
            ['url' => '/decision', 'label' => $hive->get("web.принять_решение")
],
            ['url' => '/sadness', 'label' => $hive->get("web.мне_грусно")
],
            ['url' => '/cards', 'label' => $hive->get("web.спросить_у_карт")
],
            ['url' => $hive->alias('affirmation_topics'), 'label' => $hive->get("web.войти_в_нужный_настрой")
],
        ]
    ],
    [
        'label' => $hive->get("web.прочее")
,
        'nav_links' => [
            ['url' => $hive->alias('articles'), 'label' => $hive->get("web.полезные_ресурсы")
],
            ['url' => $hive->alias('faqs'), 'label' => $hive->get("web.часто_задаваемые_вопросы")
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
        <?= component('web/ui/nav-link', ['url' => '/login', 'label' => $hive->get("web.войти")
, 'class' => 'sm:hidden']) ?>
        <?php foreach ($nav_links as $link) : ?>
            <?= component('web/ui/nav-link', $link) ?>
        <?php endforeach; ?>
    </ol>
</nav>
