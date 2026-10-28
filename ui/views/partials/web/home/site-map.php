<?php $hive = \Base::instance(); ?>
<?php $items = [
    [
        'img' => '/assets/images/pages/home/site-map/item-1',
        'alt' => 'Crystal ball',
        'title' => $hive->get("web.принять_решение") ,
        'description' => $hive->get("web.иногда_кажется_что_мысли_застряли_в_круге_сомнений_здесь_собраны_инструменты_которые_помогут_поновому_взглянуть_на_ситуацию_и_выбрать_свой_путь") ,
        'url' => '/decision'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-2',
        'alt' => 'Deck of cards',
        'title' => qquila1Бонус: экспресс-карта от Lavanda <sup>Kim</sup>qquila2
,
        'description' => qquila1Давайте поиграем? Проверим силу Лаванды? Здесь можно получить карту, которая попробует пояснить, почему вы сейчас здесь. Этот бесплатный раздел - демонстрация небольшого функционала данного веб-ресурса. И здесь мы решили показать вам авторскую колоду с уникальным «кошачьим» дизайном. Это не магия, это выборка алгоритмов, которая порой удивительно попадает в точку.qquila2
,
        'url' => $hive->alias('bonus')
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-3',
        'alt' => 'Glass bowl with a rose inside',
        'title' => $hive->get("web.мне_грустно")
,
        'description' => qquila1Грусть — это часть жизни, и иногда важно не загонять её внутрь, а мягко прожить. Здесь вы сможете выбрать то, что поможет именно сейчас. Этот раздел создан, чтобы помочь вам почувствовать: вы не одни в своей грусти, всегда можно найти слово или знак, который вернет немного тепла. А может Lavanda Kim раскроет вам причины или подарит новые вдохновения? Попробуйте! Это самый популярный раздел у наших подписчиков.qquila2
,
        'url' => '/sadness'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-4',
        'alt' => 'Golden decoration with feathers',
        'title' => $hive->get("web.войти_в_нужный_настрой")
,
        'description' => $hive->get("web.короткие_слова_иногда_способны_сделать_больше_чем_длинные_рассуждения_в_этом_разделе_вы_найдете_простое_послание_на_день_напоминание_о_вашей_силе_ценности_и_возможности_справляться_с_любыми_ситуациями_это_как_маленькая_заметка_от_самой_себя_которая_поддерживает_и_вдохновляет_выбирайте_свою_тему_карьера_материнство_любовь_и_отношения_и_настраивайтесь_на_успех")
,
        'url' => $hive->alias('affirmation_topics')
    ],
    // [
    //     'img' => '/assets/images/pages/home/site-map/item-5',
    //     'alt' => 'Cup of coffee with a rose on the side',
    //     'title' => $hive->get("web.хочу_расслабиться")
,
    //     'description' => $hive->get("web.мы_часто_думаем_о_том_что_должны_быть_продуктивными_сильными_собранными_но_не_меньшее_значение_имеет_умение_отдыхать_здесь_собрана_подборка_ресурсов_которые_помогут_расслабиться_и_восстановить_силы_музыка_медитации_дыхательные_практики_статьи_о_заботе_о_себе_это_пространство_где_можно_замедлиться_и_позволить_себе_просто_быть")
,
    //     'url' => $hive->alias('home')
    // ],
    [
        'img' => '/assets/images/pages/home/site-map/item-6',
        'alt' => 'Golden key bound by a violet band',
        'title' => $hive->get("web.полезные_ресурсы")
,
        'description' => $hive->get("web.когда_мы_ищем_ответы_всегда_помогают_дополнительные_источники_вдохновения_опыт_друга_или_эксперта_в_этом_разделе_собраны_книги_статьи_сайты_и_практики_которые_могут_стать_спутниками_на_вашем_пути_это_база_знаний_которая_постоянно_пополняется_и_к_которой_можно_возвращаться_чтобы_находить_новые_идеи_укрепляться_и_развиваться")
,
        'url' => $hive->alias('articles')
    ],
]; ?>

<section>
    <h2><?= $hive->get("web.разделы_сайта_") ?>
</h2>

    <ul class='grid gap-y-10 sm:gap-y-11 lg:gap-y-16'>
        <?php foreach ($items as $item) : ?>
            <li class='py-12.5 relative isolate before:absolute before:bottom-0 before:-inset-x-4 before:border-b before:border-primary after:absolute after:top-0 after:-inset-x-4 after:border-t after:border-primary flex sm:gap-4 flex-col sm:flex-row gap-7.5 sm:before:hidden sm:after:hidden lg:gap-12  2xl:gap-12 items-center group'>
                <?= component('shared/ui/image', [
                    'sizes'    => 'mb',
                    'alt' => $item['alt'],
                    'path'     => $item['img'],
                    'prt_class' => 'aspect-square w-full max-w-75 sm:max-w-84 lg:max-w-87.5 aspect-square bg-contain! shrink-0 group-even:sm:order-2 group-even:sm:-mr-20 group-even:md:mr-0 group-odd:sm:-ml-20 group-odd:md:ml-0',
                    'img_class' => 'size-full object-contain!',
                ]) ?>

                <div>
                    <h3 class='text-left'><?= $item['title'] ?></h3>
                    <p class='wrap-break-word'><?= $item['description'] ?></p>

                    <?= component('web/ui/button', [
                        'variant' => 'outline',
                        'slot' => $hive->get("web.перейти_в_раздел")
,
                        'href' => $item['url'],
                        'class' => 'w-fit mt-10'
                    ]) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.узнать_больше_о_ресурсе")
,
        'href' => '/about',
        'class' => 'w-fit mt-(--spacing-y) mx-auto'
    ]) ?>
</section>
