<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.спросить_у_карт"),
]); ?>

<?php ob_start(); ?>
<?= $hive->get("web.спросить_у_карт_") ?>

<?php $heading = ob_get_clean(); ?>

<?php ob_start(); ?>
<p>
    <?= $hive->get('web.карты_появились_задолго_до_психологических_тестов_и_книг_по_саморазвитию_с_их_помощью_люди_пытались_разобраться_в_любви_выборе_страхах_и_будущем_проходили_столетия_менялись_эпохи_но_вопросы_оставались_теми_же_сегодня_существуют_десятки_разных_колод_каждая_говорит_на_своем_языке_и_посвоему_помогает_взглянуть_на_происходящее_почему_люди_продолжают_обращаться_к_ним_снова_и_снова_может_потому_что_за_символами_люди_часто_замечают_самих_себя_') ?>
</p>
<?php $html = ob_get_clean(); ?>

<?php $image = '/assets/images/pages/cards/hero-fg'; ?>

<?php $items = [
    [
        'img' => '/assets/images/pages/cards/item-1',
        'alt' => $hive->get("web.колода_карт_с_фиолетовым_символом_в_центре_каждой_карты"),
        'title' => $hive->get("web.карты_таро"),
        'description' => $hive->get("web.за_каждой_картой_таро_скрывается_история_о_человеке_о_любви_и_страхе_о_выборе_и_надежде_о_потерях_ошибках_и_новых_началах_поэтому_спустя_сотни_лет_мы_попрежнему_узнаём_в_этих_историях_самих_себя"),
        'url' => $hive->alias('tarot'),
    ],
    [
        'img' => '/assets/images/pages/cards/item-2',
        'alt' => $hive->get("web.зеленая_книга_с_цветком_розы"),
        'title' => $hive->get("web.гадание_госпожи_ленорман"),
        'description' => $hive->get("web.эта_колода_словно_рассказывает_историю_каждая_карта_сама_по_себе_проста_но_вместе_они_складываются_в_картину_происходящего_ленорман_помогает_разобраться_в_отношениях_работе_выборе_и_жизненных_ситуациях_показывая_не_только_ответ_но_и_то_как_события_связаны_между_собой"),
        'url' => $hive->alias('lenormand'),
    ],
    [
        'img' => '/assets/images/pages/cards/item-3',
        'alt' => $hive->get("web.синяя_книга_перевязанная_лентой"),
        'title' => $hive->get("web.метафорические_карты"),
        'description' => $hive->get("web.один_и_тот_же_образ_каждый_человек_понимает_посвоему_бывает_смотришь_на_картинку_и_вдруг_понимаешь_чтото_о_чём_даже_не_думал_именно_так_работают_метафорические_карты_каждый_человек_увидит_в_одном_и_том_же_образе_свою_историю"),
        'url' => $hive->alias('metaphoric'),
    ],
]; ?>

<section class='full-bleed'>
    <?= component('web/layout/hero-game', compact('heading', 'html', 'image')); ?>

    <ul
        class="grid [--sq-size:min(100%,20.6rem)] md:[--sq-size:25.6rem] -mt-12 sm:-mt-25 px-2 relative grid-cols-[repeat(auto-fit,var(--sq-size))] justify-center gap-8 md:gap-10">

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
