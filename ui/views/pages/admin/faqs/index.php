<?php

use Enums\SessionKey;

$hive = \Base::instance();

extract(component_props(
    required: ['faqs'],
    optional: [],
    props: get_defined_vars(),
));

$locale = $hive->get('SESSION.' . SessionKey::RESOURCE_LOCALE->value);
?>

<?php slot('layouts/item-layout', [
    'heading' => $hive->get('admin.faqs'),
    'title' => $hive->get('admin.faqs')
]); ?>

<div class="space-y-8 w-[calc(100%-1rem)]">
    <nav class='flex flex-wrap w-full items-start gap-10 justify-between'>
        <?= component('ui/auth-button', [
            'variant' => 'primary',
            'class'   => 'h-9 rounded-sm text-sm sm:order-2',
            'slot' => $hive->get('admin.create_new'),
            'href' => $hive->alias('admin_faqs_create'),
        ]) ?>

        <?= component('ui/resource-locale-picker') ?>
    </nav>

    <?php if (! empty($faqs)) : ?>
        <ul class="grid gap-6 max-w-lg">

            <?php foreach ($faqs as $faq) : ?>
                <?php view('pages/admin/faqs/partials/item', [
                    'faq' => $faq,
                ]); ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class='-mt-3'><?= $hive->get('admin.there_are_no_faqs_here_yet') ?></p>
    <?php endif; ?>
</div>

<?php end_slot(); ?>
