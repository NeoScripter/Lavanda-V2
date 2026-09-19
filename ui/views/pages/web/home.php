<?php $hive = \Base::instance(); ?>
<?php slot('layouts/web/app-layout', [
    'title' => 'Главная',
]); ?>

<?php slot('components/web/layout/hero'); ?>
<section class='space-y-8 md:space-y-12'>
    <h1 class='mb-2'>Ответ ближе, чем кажется</h1>

    <div class='text-center text-balance sm:hidden md:block max-w-lg mx-auto isolate z-1'>
        <p><?= $hive->get('web.Любовь_Выбор_Страх_Надежда') ?></p>
        <p class='sm:hidden md:block'><?= $hive->get('web.Проходят_столетия_но_то_что_действительно_важно_человеку_остаётся_неизменным') ?></p>
    </div>

    <div class='lg:flex'>

        <div class='text-balance hidden sm:block md:hidden max-w-2/3 mb-6'>
            <p><?= $hive->get('web.Любовь_Выбор_Страх_Надежда') ?></p>
            <p><?= $hive->get('web.Проходят_столетия_но_то_что_действительно_важно_человеку_остаётся_неизменным') ?></p>
        </div>

        <div class='relative isolate lg:basis-1/2'>
            <ul class='space-y-2 mb-20 2xl:mb-50'>
                <?php foreach (explode('|', $hive->get('web.Что_я_чувствую|Что_я_на_самом_деле_хочу|Куда_двигаться_дальше|Какое_решение_будет_правильным|Какими_могут_быть_наши_отношения|Когда_придет_время')) as $qtn) : ?>
                    <li class='bg-white px-4 py-2 rounded-full rounded-br-none shadow-accent w-fit'><?= $qtn . '?' ?></li>
                <?php endforeach; ?>
            </ul>

            <?= component('admin/ui/image', [
                'sizes'    => 'mb|tb',
                'alt' => 'Stairs',
                'path'     => '/assets/images/pages/home/hero/hero-fg',
                'prt_class' => 'aspect-square h-4/3 absolute! inset-y-0 sm:h-5/4 -top-10 sm:-top-5 -right-1/5 md:-right-5 bg-contain! -z-1 lg:right-auto lg:-left-1/3 xl:-left-1/5 lg:h-160 lg:-top-1/4 lg:opacity-80 xl:h-180 2xl:h-200',
                'img_class' => 'size-full object-contain!',
            ]) ?>

        </div>
        <article class='lg:basis-1/2'>
            <header class='text-center text-balance'>
                <h2 class='text-2xl md:text-3xl! lg:text-4xl!'>Попробуйте одну карту</h2>
                <p>Авторская колода "Почему вы сегодня здесь"</p>
            </header>

            <div class='h-60 w-100  border border-red-400'>

            </div>

            <div class='flex flex-col items-center justify-center gap-4 md:flex-row'>
                <div>
                    <?= component('web/ui/button', [
                        'variant' => 'primary',
                        'slot' => 'Открыть карту',
                        'class' => 'mx-auto',
                    ]) ?>
                    <small>Бесплатно. Без регистрации</small>
                </div>
                <div>
                    <?= component('web/ui/button', [
                        'variant' => 'accent',
                        'slot' => 'Следующий раздел',
                        'class' => 'mx-auto',
                    ]) ?>
                    <small>Позвольте Lavanda вести вас</small>
                </div>
            </div>
        </article>
    </div>
</section>
<?php end_slot(); ?>

<?php end_slot(); ?>
