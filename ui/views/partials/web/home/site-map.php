<?php $hive = \Base::instance(); ?>
<?php $items = [
    [
        'img' => '/assets/images/pages/home/site-map/item-1',
        'alt' => 'Crystal ball',
        'title' => $hive->get("web.принять_решение"),
        'description' => $hive->get("web.иногда_кажется_что_мысли_застряли_в_круге_сомнений_здесь_собраны_инструменты_которые_помогут_поновому_взглянуть_на_ситуацию_и_выбрать_свой_путь"),
        'url' => '/decision'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-2',
        'alt' => 'Deck of cards',
        'title' => "{$hive->get("web._бонус_экспресскарта_от_")} Lavanda <sup>Kim</sup>",
        'description' => $hive->get('web.давайте_поиграем_проверим_силу_лаванды_здесь_можно_получить_карту_которая_попробует_пояснить_почему_вы_сейчас_здесь_этот_бесплатный_раздел_демонстрация_небольшого_функционала_данного_вебресурса_и_здесь_мы_решили_показать_вам_авторскую_колоду_с_уникальным_кошачьим_дизайном_это_не_магия_это_выборка_алгоритмов_которая_порой_удивительно_попадает_в_точку'),
        'url' => $hive->alias('bonus')
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-3',
        'alt' => 'Glass bowl with a rose inside',
        'title' => $hive->get("web.мне_грустно"),
        'description' =>

        $hive->get('web.грусть_это_часть_жизни_и_иногда_важно_не_загонять_её_внутрь_а_мягко_прожить_здесь_вы_сможете_выбрать_то_что_поможет_именно_сейчас_этот_раздел_создан_чтобы_помочь_вам_почувствовать_вы_не_одни_в_своей_грусти_всегда_можно_найти_слово_или_знак_который_вернет_немного_тепла_а_можетраскроет_вам_причины_или_подарит_новые_вдохновения_попробуйте_это_самый_популярный_раздел_у_наших_подписчиков'),
        'url' => '/sadness'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-4',
        'alt' => 'Golden decoration with feathers',
        'title' => $hive->get("web.войти_в_нужный_настрой"),
        'description' => $hive->get("web.короткие_слова_иногда_способны_сделать_больше_чем_длинные_рассуждения_в_этом_разделе_вы_найдете_простое_послание_на_день_напоминание_о_вашей_силе_ценности_и_возможности_справляться_с_любыми_ситуациями_это_как_маленькая_заметка_от_самой_себя_которая_поддерживает_и_вдохновляет_выбирайте_свою_тему_карьера_материнство_любовь_и_отношения_и_настраивайтесь_на_успех"),
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
        'title' => $hive->get("web.полезные_ресурсы"),
        'description' => $hive->get("web.когда_мы_ищем_ответы_всегда_помогают_дополнительные_источники_вдохновения_опыт_друга_или_эксперта_в_этом_разделе_собраны_книги_статьи_сайты_и_практики_которые_могут_стать_спутниками_на_вашем_пути_это_база_знаний_которая_постоянно_пополняется_и_к_которой_можно_возвращаться_чтобы_находить_новые_идеи_укрепляться_и_развиваться"),
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
                        'slot' => $hive->get("web.перейти_в_раздел"),
                        'href' => $item['url'],
                        'class' => 'w-fit mt-10'
                    ]) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.узнать_больше_о_ресурсе"),
        'href' => '/about',
        'class' => 'w-fit mt-(--spacing-y) mx-auto'
    ]) ?>
</section>
