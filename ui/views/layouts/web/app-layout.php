<?php

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'slot'],
    optional: [],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/web/app-shell', compact('title')); ?>

<div class='space-y-(--padding-gap) pt-(--padding-outer-sm)'>
    <header class="fixed top-0 inset-x-0">
        this is header
    </header>
    <main
        class='full-bleed-parent gap-(--padding-gap)'>

        <?= $slot ?? '' ?>

    </main>
</div>

<?php end_slot(); ?>
