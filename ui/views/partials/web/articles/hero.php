<?php $hive = \Base::instance(); ?>

<section class='full-bleed mb-[calc(var(--sq-size)/-4)] lg:mb-0 [--sq-size:min(26.875rem,90vw)]'>
    <?php slot('components/web/layout/hero', [
        'class' => "bg-white"
    ]); ?>
    <div class='lg:flex lg:items-start lg:gap-23.25 mb-[calc(var(--sq-size)/8)] lg:mb-0'>
        <div class='space-y-8 md:space-y-12'>
            <h1 class='mb-2 text-left'><?= $hive->get("web.полезные_ресурсы_") ?> </h1>

            <div class='space-y-[1em]'>
                <p><?= $hive->get("web.в_этом_разделе_мы_собираем_ссылки_на_ресурсы_которые_помогают_авторам_и_подписчикам_") ?> </p>

                <p>
                    <?= $hive->get('web._здесь_все_что_может_быть_полезным_для_поддержания_баланса_гармонии_для_расслабления_или_вдохновения_будь_то_музыка_для_сна_или_любимый_белый_шум_книга_которая_изменила_жизнь_или_видеоаудио_канал_а_может_это_будет_рекомендация_конкретного_эксперта_или_автора_каждому_отзовется_чтото_свое_') ?>
                </p>

                <p><?= $hive->get("web.делитесь_вашими_любимыми_ресурсами_и_адресами_наша_команда_рассмотрит_каждую_ссылку_и_рекомендацию_проверенные_ресурсы_и_конктакты_будут_представлены_на_нашем_сайте_со_ссылкой_на_автора_") ?>
                </p>
            </div>

        </div>

        <?= component('shared/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => 'some white drawing',
            'path'     => '/assets/images/pages/articles/hero-fg',
            'prt_class' => 'size-(--sq-size) hidden lg:block lg:shrink-0 rounded-xl shadow-accent 2xl:size-122.5',
            'img_class' => 'size-full object-cover object-center',
        ]) ?>

    </div>
    <?php end_slot(); ?>

    <?= component('shared/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'some white drawing',
        'path'     => '/assets/images/pages/articles/hero-fg',
        'prt_class' => 'size-(--sq-size) lg:hidden -translate-y-[calc(var(--sq-size)/4)] mx-auto rounded-xl shadow-accent',
        'img_class' => 'size-full object-cover object-center',
    ]) ?>

</section>
