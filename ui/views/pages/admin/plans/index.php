<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['plans'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/admin/item-layout', [
    'heading' => $hive->get('admin.plans'),
    'title' => $hive->get('admin.plans')
]); ?>

<div class="space-y-8 w-[calc(100%-1rem)]">
    <?php if (! empty($plans)) : ?>
        <ul class="grid gap-6 max-w-sm">

            <?php foreach ($plans as $plan) : ?>
                <?php view('pages/admin/plans/partials/item', [
                    'plan' => $plan,
                ]); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_plans_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
