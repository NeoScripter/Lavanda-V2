<?php

extract(component_props(
    required: ['stone'],
    optional: ['heading' => '', 'title' => ''],
    props: get_defined_vars(),
));

$hive = \Base::instance();

slot('layouts/item-layout', [
    'model' => 'stones',
    'model_id' => $stone['id'],
    'heading' => $heading,
    'title' => $title,
]); ?>

<div class="space-y-6">

    <?= component('ui/subheading', ['title' => $heading]) ?>

    <form action="<?= $hive->alias('admin_stones_update') ?>" method="post" class="space-y-6 max-w-160" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="put">
        <?= csrf() ?>

        <?= component('form/form-input', [
            'name'  => 'name',
            'label' => $hive->get('admin.stone_name'),
            'attrs' => [
                'type'     => 'text',
                'value'    => $stone['name'],
                'required' => true,
            ],
        ]) ?>

        <?= component('form/form-wysiwyg', [
            'name'  => 'html',
            'label' => $hive->get('admin.stone_meaning'),
            'attrs' => [
                'required' => true,
                'value'    => $stone['html'],
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'image',
            'label' => $hive->get('admin.stone_image'),
            'with_alt' => true,
            'can_delete' => false,
            'value'    => [$stone['image'] ?? null],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>

        <?= component('form/form-file-input', [
            'name'  => 'preview',
            'label' => $hive->get('admin.stone_preview'),
            'with_alt' => true,
            'can_delete' => false,
            'value'    => [$stone['preview'] ?? null],
            'attrs' => [
                'multiple' => false,
            ],
        ]) ?>


        <div class="flex justify-start gap-4.5">
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.save'),
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
            <?= component(
                'ui/auth-button',
                [
                    'slot' => $hive->get('admin.cancel'),
                    'href' => $hive->alias('admin_stones_index'),
                    'variant' => 'secondary',
                    'attrs' => ['type' => 'submit']
                ]
            ) ?>
        </div>
    </form>
</div>

<?php end_slot(); ?>
