<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['affirmations', 'topics'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/affirmation-layout', [
    'heading' => $hive->get('admin.affirmations'),
    'title' => $hive->get('admin.affirmations'),
    'topics' => $topics
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_affirmations_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($affirmations)) : ?>
        <ul class="grid gap-12 max-w-lg">

            <?php foreach ($affirmations as $affirmation) : ?>
                <?php view('pages/admin/affirmations/partials/item', [
                    'affirmation' => $affirmation,
                ]); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_affirmations_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
