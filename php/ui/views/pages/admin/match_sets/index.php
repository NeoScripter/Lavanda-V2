<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['match_sets'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/match-set-layout', [
    'heading' => $hive->get('admin.match_sets'),
    'title' => $hive->get('admin.match_sets')
]); ?>

<div class="space-y-12 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_match_sets_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($match_sets['subset'])) : ?>
        <ul class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-12">
            <?php foreach ($match_sets['subset'] as $match_set) : ?>
                <?php view('pages/admin/match_sets/partials/item', [
                    'match_set' => $match_set->to_resource(),
                ]); ?>
            <?php endforeach; ?>
        </ul>

        <?= component('ui/pagination', ['page' => $match_sets]) ?>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_match_sets_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
