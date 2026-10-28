<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.о_ресурсе"),
]); ?>


<?php $image = '/assets/images/pages/about/hero-fg'; ?>

<section class='full-bleed'>

    <?php slot('components/web/layout/hero', ['class' => 'shadow-none relative pb-0 sm:pb-0 lg:pb-0 xl:pb-0']); ?>

    <div class='flex flex-col gap-8 md:gap-12 isolate lg:flex-row lg:items-center'>
        <?= component('shared/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => 'black-cat',
            'path'     => $image,
            'prt_class' => 'shrink-0 bg-contain! lg:order-2 max-w-xl aspect-square lg:max-w-2/5 2xl:max-w-[min(40%,40rem)] mx-auto w-[min(100%,20rem)] xs:w-[max(50%,20rem)] lg:w-full',
            'img_class' => 'size-full object-contain',
        ]) ?>

        <div class='space-y-8 md:space-y-12 text-balance'>
            <h1 class='mb-2 text-left'>
                Lavanda<sup>Kim</sup> - <?= $hive->get("web.то_во_что_мы_верим_") ?>

            </h1>

            <div class='space-y-[1em]'>
                <p><?= $hive->get("web._создавалась_как_пространство_в_которое_хочется_возвращаться_") ?>
                </p>
                <p><?= $hive->get("web.здесь_нет_бесконечной_ленты_случайных_советов_и_информационного_шума_только_инструменты_которые_помогают_остановиться_посмотреть_на_ситуацию_чуть_глубже_и_услышать_себя_") ?>
                </p>
                <p><?= $hive->get("web.каждый_раздел_каждая_интерпретация_и_каждая_практика_были_тщательно_отобраны_и_созданы_специально_для_этого_проекта_") ?>
                </p>
            </div>

        </div>
    </div>
    <?php end_slot(); ?>

</section>

<?php
$items = [
    [
        'title' => $hive->get("web.авторские_материалы"),
        "description" => $hive->get("web.большинство_текстов_интерпретаций_и_практик_написаны_специально_для_и_не_встречаются_на_других_ресурсах")

    ],
    [
        'title' => $hive->get("web.психология_и_символы"),
        "description" => $hive->get("web.над_трактовками_работают_специалисты_в_области_психологии_и_гештальттерапии_символические_системы_становятся_не_развлечением_а_поводом_для_размышления_и_новых_вопросов")

    ],
    [
        'title' => $hive->get("web.бережный_подход"),
        "description" => $hive->get("web.здесь_нет_рекламы_всплывающих_окон_и_бесконечных_рекомендаций_ничто_не_отвлекает_от_самого_важного_вашего_внутреннего_диалога")

    ],
    [
        'title' => $hive->get("web.проверенные_инструменты_"),
        "description" => $hive->get("web.метафорические_карты_авторские_колоды_руны_книга_перемен_практики_минералы_всё_собрано_в_одном_пространстве_и_прошло_тщательный_отбор")

    ],
    [
        'title' => $hive->get("web.качество_важнее_количества"),
        'description' => $hive->get("web.мы_не_стремились_собрать_сотни_одинаковых_раскладов_в_остаются_только_те_инструменты_которые_действительно_помогают_взглянуть_на_ситуацию_с_новой_стороны")

    ],
    [
        'title' => $hive->get("web.почему_доступ_платный"),
        "description" => $hive->get("web.создание_такого_пространства_требует_времени_работы_специалистов_и_постоянного_развития_проекта")

    ],
    [
        'title' => $hive->get("web.стоимость_подписки_это_возможность_поддерживать_качество_материалов_создавать_новые_разделы_и_сохранять_спокойным_местом_без_рекламы_и_навязанных_рекомендаций"),
        "description" => $hive->get("web.перед_оформлением_подписки_можно_бесплатно_познакомиться_с_проектом_и_посмотреть_насколько_вам_откликается_этот_формат")

    ],
]; ?>

<section class='full-bleed px-(--px-lg) py-(--spacing-y) relative isolate before:-z-1 before:absolute before:inset-0 before:bg-primary-accent/88 bg-no-repeat bg-cover bg-center text-white' style="background-image: url(/assets/images/pages/about/benefits-bg-mb.webp)">
    <span></span>
    <h2 class='text-white'><?= $hive->get("web.что_делает_особенной_") ?>
    </h2>
    <ol class="mx-auto max-w-250">
        <?php foreach ($items as $item) : ?>

            <li class='py-[1.5em] border-b border-white list-decimal list-inside font-bold text-lg md:text-xl xl:text-2xl'>
                <span><?= $item['title'] ?></span>
                <p class='font-normal text-base md:text-lg xl:text-xl mt-[1em]'><?= $item['description'] ?></p>
            </li>
        <?php endforeach; ?>

    </ol>

</section>


<section>
    <h2>
        <?= $hive->get('web.почему_доступ_платный_') ?>
    </h2>

    <div class='space-y-[1em] max-w-200 mx-auto'>
        <p><?= $hive->get("web.в_интернете_действительно_много_бесплатных_сайтов_с_онлайнгаданиями_но_") ?>
            <sup>Kim</sup> -
            <?= $hive->get("web.это_не_генератор_случайных_карт_и_не_сборник_шаблонных_трактований_") ?>
            .
        </p>

        <p><?= $hive->get("web.платформа_создана_для_тех_кто_ценит_внимательный_подход_глубину_и_спокойное_пространство_без_шума_и_рекламы_") ?>
        </p>

        <p><?= $hive->get("web.поэтому_доступ_к_ресурсу_платный_чтобы_сохранять_качество_развивать_проект_и_поддерживать_работу_команды_") ?>
            <sup>Kim</sup> —
            <?= $hive->get("web.это_не_поток_случайных_трактований_а_пространство_избранных_подсказок") ?>

        </p>

        <p><?= $hive->get("web.при_регистрации_вы_можете_протестировать_сайт_в_течение_часов_чтобы_прочувствовать_его_возможности_и_приемущества_") ?>
        </p>
    </div>

    <div class='flex flex-wrap justify-center gap-6 lg:gap-8 items-center mt-[3.5em]'>
        <?= component('web/ui/button', [
            'variant' => 'outline',
            'slot' => $hive->get("web.вернуться_на_главную"),
            'class' => 'w-fit',
            'href' => $hive->alias('home')
        ]) ?>
        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => $hive->get("web.подробнее_о_тарифах"),
            'class' => 'w-fit',
            'href' => '/plans'
        ]) ?>

    </div>
</section>

<section>
    <article class='bg-white rounded-2xl shadow-accent flex flex-col gap-14 px-6 py-8 sm:px-12.5 sm:py-13 lg:px-23 lg:py-22.5 lg:pb-30 2xl:px-24 2xl:py-21 lg:flex-row xl:gap-0'>
        <div>
            <h2 class='text-left'><?= $hive->get("web.об_авторе_") ?>
            </h2>

            <div class='space-y-[1em] max-w-200'>
                <p><?= $hive->get("web.этот_проект_создан_человеком_который_хорошо_знает_что_такое_сомнения_новые_начала_и_возвращение_к_себе_опыт_в_консалтинге_и_личные_поворотные_этапы_жизни_стали_основой_пространства_поддержки_здесь_бережно_собраны_любимые_инструменты_а_их_логика_алгоритмы_и_визуализации_продуманы_до_деталей_") ?>
                </p>

                <p><?= $hive->get("web.здесь_нет_универсальных_рецептов_но_есть_слова_образы_и_практики_которые_помогают_услышать_свой_голос_снизить_тревогу_и_сделать_следующий_шаг_чуть_увереннее_наедине_с_собой_и_") ?>
                </p>

                <p><?= $hive->get("web.тепло_конфиденциально_и_вам_здесь_рады_") ?>
                </p>

                <p><?= $hive->get("web.с_уважением_к_вам_и_вашему_выбору_") ?>
                </p>
            </div>
        </div>

        <div class='relative lg:w-60 xl:w-123 lg:shrink-0 lg:ml-auto'>
            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => $hive->get("web.абстрактный_светлый_фон_из_полупрозрачной_струящейся_ткани_с_мягкими_складками_и_плавными_линиями"),
                'path'     => '/assets/images/pages/about/author-bg',
                'prt_class' => 'w-full rounded-2xl lg:aspect-2/3 xl:aspect-3/4 xl:w-2/3 xl:ml-auto',
                'img_class' => 'size-full object-cover',
            ]) ?>

            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => $hive->get("web.портрет_светловолосой_женщины_в_очках_с_тонкой_оправой_нейтральное_выражение_лица_мягкий_дневной_свет_светлый_фон"),
                'path'     => '/assets/images/pages/about/author-fg',
                'prt_class' => 'w-1/2 mx-auto lg:mx-0 absolute! inset-0 lg:w-60 aspect-4/5 lg:top-5 xl:w-2/3 xl:bottom-0 xl:left-0 xl:translate-y-1/3',
                'img_class' => 'size-full object-cover',
            ]) ?>

        </div>
    </article>
</section>

<section>
    <h2>
        <?= $hive->get('web.остались_вопросы_') ?>
    </h2>

    <div class='space-y-[1em] max-w-200 mx-auto'>
        <p><?= $hive->get("web.в_разделе_вопросы_и_ответы_мы_собрали_еще_больше_информации_чтобы_как_можно_подробнее_рассказать_о_ресурсе_") ?>
        </p>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.вопросы_и_ответы"),
        'class' => 'mt-[2.5em] mx-auto w-fit',
        'href' => $hive->alias('faqs')
    ]) ?>
</section>

<?php end_slot(); ?>
