<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['items'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.practice'),
    'title' => $hive->get('admin.practice')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_practice_items_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($items['subset'])) : ?>
        <ul class="grid gap-12">

            <?php foreach ($items['subset'] as $item) : ?>
                <?php view('pages/admin/practice_items/partials/item', [
                    'item' => $item->to_resource(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $items]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_items_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
