<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['ichings'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.iching'),
    'title' => $hive->get('admin.iching')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($ichings)) : ?>
        <ul class="grid grid-cols-[repeat(auto-fit,minmax(7rem,1fr))] w-full gap-6">

            <?php foreach ($ichings as $iching) : ?>
                <?php view('pages/admin/ichings/partials/item', [
                    'iching' => $iching,
                ]); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_ichings_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
