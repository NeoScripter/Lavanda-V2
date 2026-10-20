<?php $hive = \Base::instance(); ?>
<?php $items = [
    [
        'img' => '/assets/images/pages/home/site-map/item-1',
        'alt' => 'Crystal ball',
        'title' => 'Принять решение',
        'description' => "Иногда кажется, что мысли застряли в круге сомнений. Здесь собраны инструменты, которые помогут по-новому взглянуть на ситуацию и выбрать свой путь.",
        'url' => '/decision'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-2',
        'alt' => 'Deck of cards',
        'title' => 'Бонус: экспресс-карта от Lavanda <sup>Kim</sup>',
        'description' => "Давайте поиграем? Проверим силу Лаванды? Здесь можно получить карту, которая попробует пояснить, почему вы сейчас здесь. Этот бесплатный раздел - демонстрация небольшого функционала данного веб-ресурса. И здесь мы решили показать вам авторскую колоду с уникальным «кошачьим» дизайном. Это не магия, это выборка алгоритмов, которая порой удивительно попадает в точку.",
        'url' => $hive->alias('bonus')
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-3',
        'alt' => 'Glass bowl with a rose inside',
        'title' => 'Мне грустно',
        'description' => "Грусть — это часть жизни, и иногда важно не загонять её внутрь, а мягко прожить. Здесь вы сможете выбрать то, что поможет именно сейчас. Этот раздел создан, чтобы помочь вам почувствовать: вы не одни в своей грусти, всегда можно найти слово или знак, который вернет немного тепла. А может Lavanda Kim раскроет вам причины или подарит новые вдохновения? Попробуйте! Это самый популярный раздел у наших подписчиков.",
        'url' => '/sadness'
    ],
    [
        'img' => '/assets/images/pages/home/site-map/item-4',
        'alt' => 'Golden decoration with feathers',
        'title' => 'Войти в нужный настрой',
        'description' => "Короткие слова иногда способны сделать больше, чем длинные рассуждения. В этом разделе вы найдете простое послание на день - напоминание о вашей силе, ценности и возможности справляться с любыми ситуациями. Это как маленькая заметка от самой себя, которая поддерживает и вдохновляет. Выбирайте свою тему - Карьера, Материнство, Любовь и отношения - и настраивайтесь на успех",
        'url' => $hive->alias('affirmation_topics')
    ],
    // [
    //     'img' => '/assets/images/pages/home/site-map/item-5',
    //     'alt' => 'Cup of coffee with a rose on the side',
    //     'title' => 'Хочу расслабиться',
    //     'description' => "Мы часто думаем о том, что должны быть продуктивными, сильными, собранными. Но не меньшее значение имеет умение отдыхать. Здесь собрана подборка ресурсов, которые помогут расслабиться и восстановить силы: музыка, медитации, дыхательные практики, статьи о заботе о себе. Это пространство, где можно замедлиться и позволить себе просто быть.",
    //     'url' => $hive->alias('home')
    // ],
    [
        'img' => '/assets/images/pages/home/site-map/item-6',
        'alt' => 'Golden key bound by a violet band',
        'title' => 'Полезные ресурсы',
        'description' => "Когда мы ищем ответы, всегда помогают дополнительные источники вдохновения, опыт друга или эксперта. В этом разделе собраны книги, статьи, сайты и практики, которые могут стать спутниками на вашем пути. Это база знаний, которая постоянно пополняется, и к которой можно возвращаться, чтобы находить новые идеи, укрепляться и развиваться.",
        'url' => $hive->alias('articles')
    ],
]; ?>

<section class='visibility-auto'>
    <h2>Разделы сайта</h2>

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
                        'slot' => 'Перейти в раздел',
                        'href' => $item['url'],
                        'class' => 'w-fit mt-10'
                    ]) ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => 'Узнать больше о ресурсе',
        'href' => '/about',
        'class' => 'w-fit mt-(--spacing-y) mx-auto'
    ]) ?>
</section>
