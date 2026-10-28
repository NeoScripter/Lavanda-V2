<section class='visibility-auto'>
    <h2>А что сейчас?</h2>
    <p class='text-center text-balance font-medium uppercase mb-[1.5em] text-primary text-xl md:text-3xl lg:text-4xl'>Сегодня...</p>

    <ul class='grid sm:grid-cols-2 gap-4 sm:grid-rows-2 lg:grid-cols-3 lg:grid-rows-1'>
        <?= component('web/ui/branch-item', [
            'title' => $hive->get("web.можно")
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_1_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-1',
            'words' => [$hive->get("web.чувствовать")
, $hive->get("web.довериться")
, $hive->get("web.выдохнуть")
, $hive->get("web.остановиться")
, $hive->get("web.ошибаться")
, $hive->get("web.выбирать")
, $hive->get("web.не_спешить")
, $hive->get("web.не_знать_ответа")
],
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => $hive->get("web.быть")
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_2_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-2',
            'words' => [$hive->get("web.услышанной")
, $hive->get("web.с_поддержкой")
, $hive->get("web.наедине_с_собой")
, $hive->get("web.собой")
, $hive->get("web.понятой")
, $hive->get("web.в_безопасности")
, $hive->get("web.настоящей")
, $hive->get("web.такой_какая_ты_есть")
],
            'class' => 'sm:row-span-2 sm:self-center lg:self-auto lg:row-span-1'
        ]) ?>
        <?= component('web/ui/branch-item', [
            'title' => $hive->get("web.вместе")
,
            'img_bg' => '/assets/images/pages/home/what_is_now/what_is_now_3_bg.webp',
            'img_fg' => '/assets/images/pages/home/what_is_now/branch-3',
            'words' => [$hive->get("web.теплее")
, $hive->get("web.смелее")
, $hive->get("web.спокойнее")
, $hive->get("web.легче")
, $hive->get("web.с_понимани")
�м', $hive->get("web.находить_отве")
�ы', $hive->get("web.делать_следующ")
�й шаг', $hive->get("web.идти_дальше")
],
        ]) ?>
    </ul>
</section>
