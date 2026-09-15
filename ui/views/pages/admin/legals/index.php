<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['legals'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.legals'),
    'title' => $hive->get('admin.legals')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($legals)) : ?>
        <ul class="grid gap-12">

            <?php foreach ($legals as $legal) : ?>
                <?php view('pages/admin/legals/partials/item', [
                    'legal' => $legal,
                ]); ?>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_legals_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
