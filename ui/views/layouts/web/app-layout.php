<?php

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'slot'],
    optional: [],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/web/app-shell', compact('title')); ?>

<main
    class='full-bleed-parent'>

    <?= $slot ?? '' ?>
</main>

<?php end_slot(); ?>
