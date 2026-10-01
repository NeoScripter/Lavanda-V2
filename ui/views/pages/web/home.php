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

<!-- How It Works -->
<?= partial('web/home/how-it-works', compact('cards')) ?>

<!-- What Is Now -->
<?= partial('web/home/what-is-now') ?>

<?php end_slot(); ?>
