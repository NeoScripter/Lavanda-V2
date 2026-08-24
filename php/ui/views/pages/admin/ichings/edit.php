<?php

extract(component_props(
    required: ['iching'],
    optional: [],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/item-layout', [
    'heading' => $hive->get('admin.iching'),
    'title' => $hive->get('admin.iching'),
]); ?>

<div class="space-y-6 max-w-160">
    <div class="flex items-center justify-between gap-4">
        <?= component('ui/subheading', ['title' => $hive->get('admin.edit_iching') . ' ' . $iching->number]) ?>
    </div>
    <form action="<?= $hive->alias('admin_ichings_update') ?>" method="post" class="space-y-6" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-textarea', [
            'name'  => 'description',
            'label' => $hive->get('admin.description'),
            'attrs' => [
                'required' => true,
                'value'    => $iching->description,
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
                    'href' => $hive->alias('admin_ichings_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>
