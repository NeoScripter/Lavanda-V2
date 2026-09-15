<?php

extract(component_props(
    required: ['affirmation'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

extract(component_props(
    required: ['topics'],
    optional: [],
    props: get_defined_vars(),
));

slot('layouts/affirmation-layout', [
    'heading' => $hive->get('admin.affirmations'),
    'title' => $hive->get('admin.affirmations'),
    'topics' => $topics
]); ?>


<div class="space-y-6 max-w-160">
    <div class="flex items-center justify-between gap-4">
        <?= component('ui/subheading', ['title' => $hive->get('admin.edit_affirmation')]) ?>

        <?= component('ui/item-actions-mini', [
            'delete_url' => $hive->alias("admin_affirmations_destroy", ['id' => $affirmation->id]),
            'item_label' => $hive->get('admin.affirmation'),
        ]) ?>
    </div>
    <form action="<?= $hive->alias('admin_affirmations_update') ?>" method="post" class="space-y-6" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'topic',
            'label' => $hive->get('admin.affirmation_category'),
            'options' => $topics,
            'attrs' => [
                'type'     => 'text',
                'value'    => $affirmation->topic,
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-textarea', [
            'name'  => 'quote',
            'label' => $hive->get('admin.quote'),
            'attrs' => [
                'required' => true,
                'value'    => $affirmation->quote,
            ],
        ]) ?>

        <div class="flex justify-start gap-4.5">
            <?= component(
                'ui/auth-button',
                ['slot' => $hive->get('admin.save'), 'attrs' => ['type' => 'submit']]
            ) ?>
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_affirmations_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>
