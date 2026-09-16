<?php

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'slot'],
    optional: [],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/web/app-shell', compact('title')); ?>

<main
    class='full-bleed-parent gap-16.5 sm:gap-25 lg:gap-35'>

    <?= $slot ?? '' ?>
</main>

<?php end_slot(); ?>
