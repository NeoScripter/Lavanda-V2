<?php

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Главная',
    'class' => 'bg-white',
]); ?>

<!-- Hero Section -->
<?= partial('web/home/hero', compact('cards')) ?>

<!-- Is For You -->
<?= partial('web/home/is-for-you') ?>

<!-- What You Will Get -->
<?= partial('web/home/what-you-will-get') ?>

<!-- Why It Helps -->
<?= partial('web/home/why-it-helps') ?>

<!-- Reviews -->
<?= partial('web/home/reviews') ?>

<!-- How It Works -->
<?= partial('web/home/how-it-works') ?>

<!-- What Is Now -->
<?= partial('web/home/what-is-now') ?>

<?php end_slot(); ?>
