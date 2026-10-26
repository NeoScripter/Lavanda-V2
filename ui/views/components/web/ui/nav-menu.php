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
    ['url' => '/about', 'label' => 'О ресурсе'],
    [
        'label' => 'По типу помощника',
        'nav_links' => [
            ['url' => $hive->alias('runes'), 'label' => 'Скандинавские руны'],
            ['url' =>  $hive->alias('metaphoric'), 'label' => 'Метафорические карты'],
            ['url' => '/iching', 'label' => 'Книга перемен'],
            ['url' =>  $hive->alias('dices'), 'label' => 'Тибетские кубики МО new'],
            ['url' =>  $hive->alias('stones'), 'label' => 'Самоцветы (70 камней) new'],
            ['url' =>  $hive->alias('tarot'), 'label' => 'Карты Таро'],
            ['url' =>  $hive->alias('lenormand'), 'label' => 'Карты Ленорман'],
            ['url' =>  $hive->alias('minori'), 'label' => '28 целительных моментов new'],
            ['url' => $hive->alias('mind_games'), 'label' => 'Игры разума МАК'],
            ['url' =>  $hive->alias('audios'), 'label' => 'Послание поддержки от автора'],
            ['url' => $hive->alias('practice'), 'label' => 'Практика'],
            ['url' => $hive->alias('bonus'), 'label' => 'Авторский оракул TheCat'],
        ]
    ],
    [
        'label' => 'По проблеме',
        'nav_links' => [
            ['url' => '/decision', 'label' => 'Принять решение'],
            ['url' => '/sadness', 'label' => 'Мне грусно'],
            ['url' => '/cards', 'label' => 'Спросить у карт'],
            ['url' => $hive->alias('affirmation_topics'), 'label' => 'Войти в нужный настрой'],
        ]
    ],
    [
        'label' => 'Прочее',
        'nav_links' => [
            ['url' => $hive->alias('articles'), 'label' => 'Полезные ресурсы'],
            ['url' => $hive->alias('faqs'), 'label' => 'Часто задаваемые вопросы'],
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
        <?= component('web/ui/nav-link', ['url' => '/login', 'label' => 'Войти', 'class' => 'sm:hidden']) ?>
        <?php foreach ($nav_links as $link) : ?>
            <?= component('web/ui/nav-link', $link) ?>
        <?php endforeach; ?>
    </ol>
</nav>
