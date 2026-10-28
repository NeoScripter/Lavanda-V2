<?php $hive = \Base::instance(); ?>

<?php slot('layouts/web/app-layout', [
    'title' => $hive->get("web.контакты"),
    'class' => 'bg-white relative isolate',
]); ?>

<section class='pt-(--pt-lg)'>

    <article class='bg-white rounded-2xl shadow-accent max-w-200 mx-auto px-6 py-8 sm:px-12.5 sm:py-10 lg:px-14 lg:pt-13 lg:pb-18'>
        <h1><?= $hive->get("web.контакты") ?>
        </h1>

        <div class='space-y-[1em] max-w-200 text-center text-balance'>
            <p><?= $hive->get("web.если_у_вас_возникли_вопросы_пожалуйста_свяжитесь_с_нами") ?>
            </p>
        </div>

        <a href="mailto:info@lavanda.kim" class='flex gap-[0.5em] text-lg md:text-xl xl:text-2xl transition-colors hover:text-primary-muted md:mt-[2em] mt-[1.5em] items-center text-primary w-fit mx-auto font-medium'>
            <span class='[&>svg]:size-[1.25em]'><?= svg('mail') ?></span>
            <span>info@lavanda.kim</span>
        </a>
    </article>

</section>

<span class='absolute inset-0 bg-cover bg-no-repeat bg-center -z-1 size-full' style="background-image: url(/assets/images/pages/contact/main-bg-mb.webp);"></span>

<?php end_slot(); ?>
