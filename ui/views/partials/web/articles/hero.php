<section class='full-bleed mb-[calc(var(--sq-size)/-4)] lg:mb-0 [--sq-size:min(26.875rem,90vw)]'>
    <?php slot('components/web/layout/hero', [
        'class' => "bg-white"
    ]); ?>
    <div class='lg:flex lg:items-start lg:gap-23.25'>
        <div class='space-y-8 md:space-y-12'>
            <h1 class='mb-2 text-left'>Полезные ресурсы</h1>

            <div class='space-y-[1em]'>
                <p>В этом разделе мы собираем ссылки на ресурсы, которые помогают авторам и подписчикам Lavanda Kim.</p>

                <p>Здесь все, что может быть полезным для поддержания баланса, гармонии, для расслабления или вдохновения. Будь то музыка для сна или любимый белый шум, книга, которая изменила жизнь, или видео/аудио канал. А может это будет рекомендация конкретного эксперта или автора? Каждому отзовется что-то свое.</p>

                <p>Делитесь Вашими любимыми ресурсами и адресами. Наша команда рассмотрит каждую ссылку и рекомендацию. Проверенные ресурсы и конктакты будут представлены на нашем сайте со ссылкой на автора.</p>
            </div>

        </div>

        <?= component('admin/ui/image', [
            'sizes'    => 'mb|tb',
            'alt' => 'some white drawing',
            'path'     => '/assets/images/pages/articles/hero-fg',
            'prt_class' => 'size-(--sq-size) hidden lg:block lg:shrink-0 rounded-xl shadow-accent 2xl:size-122.5',
            'img_class' => 'size-full object-cover object-center',
        ]) ?>

    </div>
    <?php end_slot(); ?>

    <?= component('admin/ui/image', [
        'sizes'    => 'mb|tb',
        'alt' => 'some white drawing',
        'path'     => '/assets/images/pages/articles/hero-fg',
        'prt_class' => 'size-(--sq-size) lg:hidden -translate-y-[calc(var(--sq-size)/4)] mx-auto rounded-xl shadow-accent',
        'img_class' => 'size-full object-cover object-center',
    ]) ?>

</section>
