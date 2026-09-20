<?php

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'slot'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/web/app-shell', compact('title')); ?>

<div class='space-y-(--padding-gap) pt-(--padding-outer-sm) <?= $class ?>'>
    <main
        class='full-bleed-parent gap-y-(--padding-gap)'>

        <?= $slot ?? '' ?>
    </main>
    <?= partial('web/shared/footer') ?>

    <?= partial('web/shared/header') ?>
</div>

<?php end_slot(); ?>
