<?php

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php slot('layouts/web/app-layout', [
    'title' => 'Главная',
]); ?>

<!-- Hero Section -->
<?= partial('web/home/hero', compact('cards')) ?>

<!-- How It Works -->
<?= partial('web/home/how-it-works', compact('cards')) ?>

<?php end_slot(); ?>
