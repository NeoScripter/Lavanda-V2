<?php
$hive = \Base::instance();
$nav_links = [
    ['url' => '/', 'label' => 'Главная'],
    [
        'label' => 'Решение',
        'nav_links' => [
            ['url' => '/education', 'label' => 'Общая информация'],
            ['url' => '/practice', 'label' => 'Практика'],
            ['url' => '/economic-development', 'label' => 'Спросить у рун'],
            ['url' => '/sustainable-environment', 'label' => 'Спросить у карт'],
            ['url' => '/social-mobilization', 'label' => 'Книга перемен'],
            ['url' => '/disaster-relief', 'label' => 'Игры разума'],
        ]
    ],
    ['url' => '/history', 'label' => 'Настрой'],
    ['url' => '/faqs', 'label' => 'Мне грустно'],
    ['url' => '/memberships', 'label' => 'Бонус игра'],
    ['url' => '/reports', 'label' => 'Расслабиться'],
    [
        'label' => 'Прочее',
        'nav_links' => [
            ['url' => $hive->alias('articles'), 'label' => 'Полезные ресурсы'],
        ]
    ],
]; ?>

<nav
    component-nav-menu
    class="<?= $class ?? '' ?> hidden sm:block sm:px-4">
    <ol class="flex flex-col sm:flex-row sm:shadow-accent sm:bg-white sm:flex-wrap sm:items-baseline text-lg md:text-base gap-4 sm:gap-x-8 lg:justify-between xl:gap-x-8 pb-10 sm:pb-4 sm:rounded-4xl sm:py-4 sm:px-6 lg:px-8">
        <?= component('web/ui/nav-link', ['url' => '/login', 'label' => 'Войти', 'class' => 'sm:hidden']) ?>
        <?php foreach ($nav_links as $link) : ?>
            <?= component('web/ui/nav-link', $link) ?>
        <?php endforeach; ?>
    </ol>
</nav>
