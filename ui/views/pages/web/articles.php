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
<?= partial('web/articles/hero') ?>

<?php end_slot(); ?>
