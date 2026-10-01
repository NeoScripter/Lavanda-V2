<?php

$hive = \Base::instance();

extract(component_props(
    required: ['title', 'slot'],
    optional: ['class' => ''],
    props: get_defined_vars()
)); ?>
<?php slot('layouts/web/app-shell', compact('title')); ?>

<div class="<?= cc('space-y-(--spacing-y) bg-background pt-(--px-sm) bg-no-repeat', $class) ?>">
    <?= partial('web/shared/header') ?>

    <main
        class='full-bleed-parent gap-y-(--spacing-y)'>

        <?= $slot ?? '' ?>
    </main>

    <?= partial('web/shared/footer') ?>
</div>

<?php end_slot(); ?>
