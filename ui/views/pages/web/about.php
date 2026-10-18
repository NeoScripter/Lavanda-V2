<?php slot('layouts/web/app-layout', [
    'title' => 'О ресурсе',
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
        'title' => "Авторские материалы",
        "description" => "Большинство текстов, интерпретаций и практик написаны специально для LavandaKim и не встречаются на других ресурсах."
    ],
    [
        'title' => "Психология и символы",
        "description" => "Над трактовками работают специалисты в области психологии и гештальт-терапии. Символические системы становятся не развлечением, а поводом для размышления и новых вопросов."
    ],
    [
        'title' => "Бережный подход",
        "description" => "Здесь нет рекламы, всплывающих окон и бесконечных рекомендаций. Ничто не отвлекает от самого важного — вашего внутреннего диалога."
    ],
    [
        'title' => "Проверенные инструменты ",
        "description" => "Метафорические карты, авторские колоды, руны, «Книга Перемен», практики, минералы — всё собрано в одном пространстве и прошло тщательный отбор."
    ],
    [
        'title' => "Качество важнее количества",
        "description" => "Мы не стремились собрать сотни одинаковых раскладов. В Lavanda остаются только те инструменты, которые действительно помогают взглянуть на ситуацию с новой стороны."
    ],
    [
        'title' => "Почему доступ платный",
        "description" => "Создание такого пространства требует времени, работы специалистов и постоянного развития проекта."
    ],
    [
        'title' => "Стоимость подписки — это возможность поддерживать качество материалов, создавать новые разделы и сохранять LavandaKim спокойным местом без рекламы и навязанных рекомендаций.",
        "description" => "Перед оформлением подписки можно бесплатно познакомиться с проектом и посмотреть, насколько вам откликается этот формат."
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
            'slot' => 'Вернуться на главную',
            'class' => 'w-fit',
            'href' => $hive->alias('home')
        ]) ?>
        <?= component('web/ui/button', [
            'variant' => 'primary',
            'slot' => 'Попробовать бесплатно',
            'class' => 'w-fit',
            'href' => $hive->alias('home')
        ]) ?>
        <?= component('web/ui/button', [
            'variant' => 'outline',
            'slot' => 'Подробнее о тарифах',
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
                'alt' => 'Абстрактный светлый фон из полупрозрачной струящейся ткани с мягкими складками и плавными линиями',
                'path'     => '/assets/images/pages/about/author-bg',
                'prt_class' => 'w-full rounded-2xl lg:aspect-2/3 xl:aspect-3/4 xl:w-2/3 xl:ml-auto',
                'img_class' => 'size-full object-cover',
            ]) ?>

            <?= component('shared/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => 'Портрет светловолосой женщины в очках с тонкой оправой, нейтральное выражение лица, мягкий дневной свет, светлый фон',
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
        'slot' => 'Вопросы и ответы',
        'class' => 'mt-[2.5em] mx-auto w-fit',
        'href' => $hive->alias('faqs')
    ]) ?>
</section>

<?php end_slot(); ?>
