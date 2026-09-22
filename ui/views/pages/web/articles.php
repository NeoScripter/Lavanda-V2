<?php

extract(component_props(
    required: [],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Полезные ресурсы',
    'class' => "bg-[url('/assets/images/pages/articles/articles-bg.webp')] bg-cover bg-center"
]); ?>

<!-- Hero Section -->
<?php slot('components/web/layout/hero', [
    'class' => "bg-white"
]); ?>
<section class='space-y-8 md:space-y-12'>
    <h1 class='mb-2 text-left'>Полезные ресурсы</h1>

    <div class='space-y-[1em]'>
        <p>В этом разделе мы собираем ссылки на ресурсы, которые помогают авторам и подписчикам Lavanda Kim.</p>

        <p>Здесь все, что может быть полезным для поддержания баланса, гармонии, для расслабления или вдохновения. Будь то музыка для сна или любимый белый шум, книга, которая изменила жизнь, или видео/аудио канал. А может это будет рекомендация конкретного эксперта или автора? Каждому отзовется что-то свое.</p>

        <p>Делитесь Вашими любимыми ресурсами и адресами. Наша команда рассмотрит каждую ссылку и рекомендацию. Проверенные ресурсы и конктакты будут представлены на нашем сайте со ссылкой на автора.</p>
    </div>

</section>
<?php end_slot(); ?>

<?php end_slot(); ?>
