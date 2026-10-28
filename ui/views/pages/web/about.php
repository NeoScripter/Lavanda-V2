<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.о_ресурсе")
,
]); ?>

<?php $hive = \Base::instance(); ?>

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
                Lavanda<sup>Kim</sup> - то, во что мы верим
            </h1>

            <div class='space-y-[1em]'>
                <p>LavandaKim создавалась как пространство, в которое хочется возвращаться.</p>
                <p>Здесь нет бесконечной ленты, случайных советов и информационного шума. Только инструменты, которые помогают остановиться, посмотреть на ситуацию чуть глубже и услышать себя.</p>
                <p>Каждый раздел, каждая интерпретация и каждая практика были тщательно отобраны и созданы специально для этого проекта.</p>
            </div>

        </div>
    </div>
    <?php end_slot(); ?>

</section>

<?php
$items = [
    [
        'title' => $hive->get("web.авторские_материалы")
,
        "description" => $hive->get("web.большинство_текстов_интерпретаций_и_практик_написаны_специально_для_и_не_встречаются_на_других_ресурсах")

    ],
    [
        'title' => $hive->get("web.психология_и_символы")
,
        "description" => $hive->get("web.над_трактовками_работают_специалисты_в_области_психологии_и_гештальттерапии_символические_системы_становятся_не_развлечением_а_поводом_для_размышления_и_новых_вопросов")

    ],
    [
        'title' => $hive->get("web.бережный_подход")
,
        "description" => $hive->get("web.здесь_нет_рекламы_всплывающих_окон_и_бесконечных_рекомендаций_ничто_не_отвлекает_от_самого_важного_вашего_внутреннего_диалога")

    ],
    [
        'title' => $hive->get("web.проверенные_инструменты_")
,
        "description" => $hive->get("web.метафорические_карты_авторские_колоды_руны_книга_перемен_практики_минералы_всё_собрано_в_одном_пространстве_и_прошло_тщательный_отбор")

    ],
    [
        'title' => $hive->get("web.качество_важнее_количества")
,
        'description' => $hive->get("web.мы_не_стремились_собрать_сотни_одинаковых_раскладов_в_остаются_только_те_инструменты_которые_действительно_помогают_взглянуть_на_ситуацию_с_новой_стороны")

    ],
    [
        'title' => $hive->get("web.почему_доступ_платный")
,
        "description" => $hive->get("web.создание_такого_пространства_требует_времени_работы_специалистов_и_постоянного_развития_проекта")

    ],
    [
        'title' => $hive->get("web.стоимость_подписки_это_возможность_поддерживать_качество_материалов_создавать_новые_разделы_и_сохранять_спокойным_местом_без_рекламы_и_навязанных_рекомендаций")
,
        "description" => $hive->get("web.перед_оформлением_подписки_можно_бесплатно_познакомиться_с_проектом_и_посмотреть_насколько_вам_откликается_этот_формат")

    ],
]; ?>

<section class='full-bleed px-(--px-lg) py-(--spacing-y) relative isolate before:-z-1 before:absolute before:inset-0 before:bg-primary-accent/88 bg-no-repeat bg-cover bg-center text-white' style="background-image: url(/assets/images/pages/about/benefits-bg-mb.webp)">
    <span></span>
    <h2 class='text-white'>Что делает Lavanda особенной</h2>
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
    <h2>Почему доступ платный?</h2>

    <div class='space-y-[1em] max-w-200 mx-auto'>
        <p>В интернете действительно много бесплатных сайтов с онлайн-гаданиями. Но Lavanda<sup>Kim</sup> - это не генератор случайных карт и не сборник шаблонных трактований.</p>

        <p>Платформа создана для тех, кто ценит внимательный подход, глубину и спокойное пространство без шума и рекламы.</p>

        <p>Поэтому доступ к ресурсу платный — чтобы сохранять качество, развивать проект и поддерживать работу команды. Lavanda<sup>Kim</sup> — это не поток случайных трактований, а пространство избранных подсказок.</p>

        <p>При регистрации вы можете протестировать сайт в течение 24 часов, чтобы прочувствовать его возможности и приемущества.</p>
    </div>

    <div class='flex flex-wrap justify-center gap-6 lg:gap-8 items-center mt-[3.5em]'>
        <?= component('web/ui/button', [
            'variant' => 'outline',
            'slot' => $hive->get("web.вернуться_на_главную")
,
            'class' => 'w-fit',
            'href' => $hive->alias('home')
        ]) ?>
        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => $hive->get("web.подробнее_о_тарифах")
,
            'class' => 'w-fit',
            'href' => '/plans'
        ]) ?>

    </div>
</section>

<section>
    <article class='bg-white rounded-2xl shadow-accent flex flex-col gap-14 px-6 py-8 sm:px-12.5 sm:py-13 lg:px-23 lg:py-22.5 lg:pb-30 2xl:px-24 2xl:py-21 lg:flex-row xl:gap-0'>
        <div>
            <h2 class='text-left'>Об авторе</h2>

            <div class='space-y-[1em] max-w-200'>
                <p>Этот проект создан человеком, который хорошо знает, что такое сомнения, новые начала и возвращение к себе. Опыт в консалтинге, IT и личные поворотные этапы жизни стали основой пространства поддержки — здесь бережно собраны любимые инструменты, а их логика, алгоритмы и визуализации продуманы до деталей.</p>

                <p>Здесь нет универсальных рецептов. Но есть слова, образы и практики, которые помогают услышать свой голос, снизить тревогу и сделать следующий шаг чуть увереннее — наедине с собой и LavandaKim.</p>

                <p>Тепло. Конфиденциально. И Вам здесь рады.</p>

                <p>С уважением к вам и вашему выбору,
                    LavandaKim</p>
            </div>
        </div>

        <div class='relative lg:w-60 xl:w-123 lg:shrink-0 lg:ml-auto'>
            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => $hive->get("web.абстрактный_светлый_фон_из_полупрозрачной_струящейся_ткани_с_мягкими_складками_и_плавными_линиями")
,
                'path'     => '/assets/images/pages/about/author-bg',
                'prt_class' => 'w-full rounded-2xl lg:aspect-2/3 xl:aspect-3/4 xl:w-2/3 xl:ml-auto',
                'img_class' => 'size-full object-cover',
            ]) ?>

            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => $hive->get("web.портрет_светловолосой_женщины_в_очках_с_тонкой_оправой_нейтральное_выражение_лица_мягкий_дневной_свет_светлый_фон")
,
                'path'     => '/assets/images/pages/about/author-fg',
                'prt_class' => 'w-1/2 mx-auto lg:mx-0 absolute! inset-0 lg:w-60 aspect-4/5 lg:top-5 xl:w-2/3 xl:bottom-0 xl:left-0 xl:translate-y-1/3',
                'img_class' => 'size-full object-cover',
            ]) ?>

        </div>
    </article>
</section>

<section>
    <h2>Остались вопросы?</h2>

    <div class='space-y-[1em] max-w-200 mx-auto'>
        <p>В разделе “Вопросы и Ответы” мы собрали еще больше информации, чтобы как можно подробнее рассказать о ресурсе.</p>
    </div>

    <?= component('web/ui/button', [
        'variant' => 'primary',
        'slot' => $hive->get("web.вопросы_и_ответы")
,
        'class' => 'mt-[2.5em] mx-auto w-fit',
        'href' => $hive->alias('faqs')
    ]) ?>
</section>

<?php end_slot(); ?>
