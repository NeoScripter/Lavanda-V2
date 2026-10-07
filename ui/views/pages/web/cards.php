<?php slot('layouts/web/app-layout', [
    'title' => 'Спросить у карт',
]); ?>

<?php $hive = \Base::instance(); ?>

<?php ob_start(); ?>
Спросить у карт
<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>Карты появились задолго до психологических тестов и книг по саморазвитию. С их помощью люди пытались разобраться в любви, выборе, страхах и будущем. Проходили столетия, менялись эпохи, но вопросы оставались теми же. Сегодня существуют десятки разных колод. Каждая говорит на своем языке и по-своему помогает взглянуть на происходящее. Почему люди продолжают обращаться к ним снова и снова? Может, потому что за символами люди часто замечают самих себя?</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/cards/hero-fg'; ?>

<?php $items = [
    [
        'img' => '/assets/images/pages/cards/item-1',
        'alt' => 'Колода карт с фиолетовым символом в центре каждой карты',
        'title' => 'Карты Таро',
        'description' => "За каждой картой Таро скрывается история о человеке. О любви и страхе. О выборе и надежде. О потерях, ошибках и новых началах. Поэтому спустя сотни лет мы по-прежнему узнаём в этих историях самих себя.",
        'url' => $hive->alias('tarot'),
    ],
    [
        'img' => '/assets/images/pages/cards/item-2',
        'alt' => 'Зеленая книга с цветком розы',
        'title' => 'Гадание Госпожи Ленорман',
        'description' => "Эта колода словно рассказывает историю. Каждая карта сама по себе проста, но вместе они складываются в картину происходящего. Ленорман помогает разобраться в отношениях, работе, выборе и жизненных ситуациях, показывая не только ответ, но и то, как события связаны между собой.",
        'url' => $hive->alias('home'),
    ],
    [
        'img' => '/assets/images/pages/cards/item-3',
        'alt' => 'Синяя книга, перевязанная лентой',
        'title' => 'Метафорические карты',
        'description' => "Один и тот же образ каждый человек понимает по-своему. Бывает, смотришь на картинку и вдруг понимаешь что-то, о чём даже не думал. Именно так работают метафорические карты. Каждый человек увидит в одном и том же образе свою историю.",
        'url' => $hive->alias('metaphoric'),
    ],
]; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>

    <ul
        class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative grid-cols-[repeat(auto-fill,var(--sq-size))] justify-center gap-8 md:gap-10">

        <?php foreach ($items as $idx => $item) : ?>
            <li
                class="rounded-2xl relative hover:ring-blue-400 hover:ring-4 bg-linear-to-b from-primary-pale to-white focus-within:ring-blue-400 focus-within:ring-4 overflow-clip shadow-accent px-6 py-8 md:px-8 md:py-10 min-h-65 md:min-h-75 flex flex-col">

                <?= component('shared/ui/image', [
                    'path' => $item['img'],
                    'alt' => $item['alt'],
                    'sizes' => 'mb',
                    'prt_class' => 'max-w-35 mx-auto mb-4',
                ]) ?>

                <h2 class='text-xl text-center md:text-2xl font-bold isolate uppercase'><?= $item['title'] ?></h2>
                <p class='lg:text-lg isolate'><?= $item['description'] ?></p>

                <a href="<?= $item['url'] ?>"
                    class='absolute inset-0 cursor-pointer'>
                </a>
            </li>

        <?php endforeach; ?>

    </ul>

</section>

<?php end_slot(); ?>
