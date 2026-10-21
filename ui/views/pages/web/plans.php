<?php slot('layouts/web/app-layout', [
    'title' => 'Подписка',
    'class' => 'bg-white relative isolate',
]); ?>

<?php $hive = \Base::instance();

$items = [
    ['title' => 'Здесь и сейчас', 'image' => '/assets/images/pages/plans/plan-1/plan-1', 'headline' => '3 вопроса - 3 ответа', 'description' => 'Когда нужен ответ на то, что волнует прямо сейчас', 'price' => 990],
    ['title' => 'Остаться на месяц', 'image' => '/assets/images/pages/plans/plan-2/plan-2', 'headline' => 'Неограниченное число обращений', 'description' => 'В период, когда один разговор не решает все', 'price' => 1990],
    ['title' => 'Быть вместе год', 'image' => '/assets/images/pages/plans/plan-3/plan-3', 'headline' => 'Неограниченное число обращений', 'description' => 'Когда хочется чтобы пространство для размышлений было рядом 365 дней в году', 'price' => 9990],
    ['title' => 'Поговорить лично с Lavanda', 'image' => '/assets/images/pages/plans/plan-4/plan-4', 'headline' => 'Персональный разбор', 'description' => 'Заполните форму, выберите формат и получите личный ответ от Lavanda на почту в течение 3 дней', 'price' => 9990],
]; ?>

<section class='pt-(--pt-lg)'>

    <h1>Подписка</h1>

    <p class='text-center text-balance'>Каждому - подходящий формат</p>

    <ul class='grid grid-cols-[repeat(auto-fit,minmax(min(100%,18.75rem),1fr))] justify-items-center gap-y-45 gap-x-10 mt-38 sm:mt-45 md:mt-50 lg:w-200 lg:mx-auto 2xl:mx-0 2xl:w-full '>
        <?php foreach ($items as $item) : ?>
            <li class='bg-white shadow-accent rounded-2xl px-7.5 pb-9 w-full max-w-75 text-balance flex flex-col gap-4 relative pt-28'>
                <?= component('shared/ui/image', [
                    'sizes' => 'mb',
                    'path' => $item['image'],
                    'prt_class' => 'bg-contain! w-[130%] aspect-video absolute! top-0 left-1/2 -translate-1/2',
                    'img_class' => 'object-contain',
                ]) ?>

                <h2 class='text-xl!'><?= $item['title'] ?></h2>
                <div class='mb-8 text-center text-balance'>
                    <p class='font-bold text-base! mb-[0.5em]'><?= $item['headline'] ?></p>
                    <p class='text-base!'><?= $item['description'] ?></p>
                </div>
                <p class='text-primary font-medium text-center text-lg md:text-xl xl:text-2xl mt-auto'><?= $item['price'] ?>₽</p>

                <?= component('web/ui/button', [
                    'variant' => 'primary',
                    'slot' => 'Открыть доступ',
                    'href' => $hive->alias('login'),
                    'class' => '',
                ]) ?>

            </li>

        <?php endforeach; ?>
    </ul>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/shared/backgrounds/flowers/flowers-mb.webp);"></span>

<?php end_slot(); ?>
