<?php $hive = \Base::instance(); ?>
<?php slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dashboard'),
    'title' => $hive->get('admin.dashboard')
]); ?>

<?php

$map = json_decode(file_get_contents(APP_DIR . '/ui/data/models/game-links.json'), true);

$items = [
    '/' =>   "Кошачий оракул (Главная)",
    '/bonus' =>   "Кошачий оракул",
    '/metaphoric'  => "Метафорические карты",
    '/stones'  => "Сила камней: 70 самоцветов",
    '/runes'  => "Скандинавские руны",
    '/dices'  => "Тибетские кубики МО",
    '/lenormand'  => "Карты Ленорман",
    '/audios'  => "Голосовые послания от автора",
    '/minori'  => "28 целительных моментов",
    '/iching'  => "Книга Перемен (И Цзин)",
    '/tarot'  => "Карты Таро",
    '/mind_games'  => "«Игры разума» — МАК",
    '/home'  => "Персональный разбор ситуации",
];

?>
<div
    class='flex h-full flex-1 items-start flex-col gap-8 rounded-xl p-4'>
    <div>
        <?= $hive->get('admin.this_is_the_dashboard_page') ?>
    </div>

    <form action="<?= $hive->alias('game_links') ?>" method="post">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>
        <ul class='grid gap-4'>
            <?php foreach ($map as $from => $to) : ?>
                <li class='flex items-center justify-center gap-8'>
                    <select name="<?= $from ?>" id="">
                        <?php foreach ($items as $route => $label) : ?>
                            <option <?= preg_replace('/[0-9]+/', '', $from) === $route ? 'selected' : '' ?> value="<?= $route ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>

                    <span>-></span>

                    <select name="<?= $to ?>" id="">
                        <?php foreach ($items as $route => $label) : ?>
                            <option <?= preg_replace('/[0-9]+/', '', $to) === $route ? 'selected' : '' ?> value="<?= $route ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </li>

            <?php endforeach; ?>
        </ul>
        <?= component('admin/ui/auth-button', [
            'class' => 'mt-8',
            'slot' => $hive->get("admin.save")
        ]) ?>
    </form>

</div>

<?php end_slot(); ?>
