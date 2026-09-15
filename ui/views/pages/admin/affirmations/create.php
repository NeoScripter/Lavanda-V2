<?php

$hive = \Base::instance();

extract(component_props(
    required: ['topics'],
    optional: [],
    props: get_defined_vars(),
));

slot('layouts/admin/affirmation-layout', [
    'heading' => $hive->get('admin.affirmations'),
    'title' => $hive->get('admin.affirmations'),
    'topics' => $topics
]); ?>

<div class="space-y-6">
    <?= component('admin/ui/subheading', ['title' => $hive->get('admin.create_affirmation')]) ?>

    <form action="<?= \Base::instance()->alias('admin_affirmations_store') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <?= csrf() ?>

        <?= component('admin/form/form-input', [
            'name'  => 'topic',
            'label' => $hive->get('admin.affirmation_category'),
            'options' => $topics,
            'attrs' => [
                'type'     => 'text',
                'required' => true,
            ],
        ]) ?>

        <?= component('admin/form/form-textarea', [
            'name'  => 'quote',
            'label' => $hive->get('admin.quote'),
            'attrs' => [
                'required' => true,
            ],
        ]) ?>

        <div class="flex items-center gap-4.5">
            <?= component('admin/ui/auth-button', [
                'slot' => $hive->get('admin.save'),
                'attrs' => ['type' => 'submit']
            ]) ?>

            <?= component('admin/ui/auth-button', [
                'slot' => $hive->get('admin.cancel'),
                'href' => $hive->alias('admin_affirmations_index'),
                'variant' => 'secondary',
                'attrs' => ['type' => 'submit']
            ]) ?>

        </div>
    </form>
</div>

<?php end_slot(); ?>
