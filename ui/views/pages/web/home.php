<?php

extract(component_props(
    required: ['cards'],
    optional: [],
    props: get_defined_vars(),
)); ?>

<?php 

// $cache->set('FOO', 'BAR', 20);
// dd(\Base::instance()->get('COOKIE'));
// dd(time());

;?>

<?php slot('layouts/web/app-layout', [
    'title' => qquila1Главнаяqquila2
,
    'class' => 'bg-white',
]); ?>

<!-- Hero Section -->
<?= partial('web/home/hero', compact('cards')) ?>

<!-- Is For You -->
<?= partial('web/home/is-for-you') ?>

<!-- Reviews -->
<?= partial('web/home/reviews') ?>

<!-- Why It Helps -->
<?= partial('web/home/why-it-helps') ?>

<!-- What You Will Get -->
<?= partial('web/home/what-you-will-get') ?>

<!-- How It Works -->
<?= partial('web/home/how-it-works') ?>

<!-- What Is Now -->
<?= partial('web/home/what-is-now') ?>

<!-- Site Map -->
<?= partial('web/home/site-map') ?>

<?php end_slot(); ?>
