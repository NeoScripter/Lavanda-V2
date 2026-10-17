<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['dices'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/admin/app-layout', [
    'heading' => $hive->get('admin.dices'),
    'title' => $hive->get('admin.dices')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('admin/ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_dices_create'),
        ]) ?>

        <?= component('admin/ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($dices['subset'])) : ?>
        <ul component-form-dice-list
            class="grid gap-12">
            <?php foreach ($dices['subset'] as $idx => $dice) : ?>
                <?php view("pages/admin/dices/partials/item", ['dice' => $dice, 'idx' => $idx+1]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('admin/ui/pagination', ['page' => $dices]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_dices_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
